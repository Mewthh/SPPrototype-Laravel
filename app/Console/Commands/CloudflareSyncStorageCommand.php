<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CloudflareSyncStorageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloudflare:sync-storage {--dry-run : List files without uploading} {--force : Overwrite existing files on R2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync existing local files from storage/app/public to the Cloudflare R2 bucket';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $localPath = storage_path('app/public');
        $isDryRun = $this->option('dry-run');
        $force = $this->option('force');

        if (! File::exists($localPath)) {
            $this->warn("Local storage directory {$localPath} does not exist. Nothing to sync.");

            return Command::SUCCESS;
        }

        $files = File::allFiles($localPath);
        $total = count($files);

        if ($total === 0) {
            $this->info("No files found in {$localPath}. Storage is empty.");

            return Command::SUCCESS;
        }

        $this->info("Found {$total} file(s) in local public storage.");

        if ($isDryRun) {
            $this->warn('[DRY RUN] The following files would be uploaded to Cloudflare R2:');
            foreach ($files as $file) {
                $relativePath = str_replace('\\', '/', $file->getRelativePathname());
                $this->line(" - {$relativePath} (".number_format($file->getSize() / 1024, 2).' KB)');
            }

            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $uploaded = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($files as $file) {
            $relativePath = str_replace('\\', '/', $file->getRelativePathname());

            try {
                if (! $force && Storage::disk('r2')->exists($relativePath)) {
                    $skipped++;
                    $bar->advance();

                    continue;
                }

                $stream = fopen($file->getRealPath(), 'r');
                if ($stream === false) {
                    $failed++;
                    $bar->advance();

                    continue;
                }

                Storage::disk('r2')->put($relativePath, $stream, 'public');
                if (is_resource($stream)) {
                    fclose($stream);
                }

                $uploaded++;
            } catch (\Throwable $e) {
                $failed++;
                $this->newLine();
                $this->error("Failed to upload {$relativePath}: ".$e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Sync completed: {$uploaded} uploaded, {$skipped} skipped (already exists), {$failed} failed.");

        return $failed === 0 ? Command::SUCCESS : Command::FAILURE;
    }
}
