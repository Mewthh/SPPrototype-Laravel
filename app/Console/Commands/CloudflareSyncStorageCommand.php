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
    protected $signature = 'cloudflare:sync-storage 
                            {--private : Sync storage/app/private to the private R2 bucket instead of public}
                            {--dry-run : List files without uploading} 
                            {--force : Overwrite existing files on R2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync existing local files from storage/app/public or storage/app/private to Cloudflare R2';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $isPrivate = $this->option('private');
        $diskName = $isPrivate ? 'r2-private' : 'r2';
        $visibility = $isPrivate ? 'private' : 'public';
        $localPath = $isPrivate ? storage_path('app/private') : storage_path('app/public');
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

        $targetLabel = $isPrivate ? 'Private R2 Bucket' : 'Public R2 Bucket';
        $this->info("Found {$total} file(s) in {$localPath} to sync to {$targetLabel} (disk: {$diskName}).");

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
                if (! $force && Storage::disk($diskName)->exists($relativePath)) {
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

                Storage::disk($diskName)->put($relativePath, $stream, $visibility);
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
