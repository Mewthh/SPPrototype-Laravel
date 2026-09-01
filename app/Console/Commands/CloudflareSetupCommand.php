<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CloudflareSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloudflare:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Cloudflare D1 database and R2 object storage connections and operations';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Testing Cloudflare Services Integration...');
        $this->newLine();

        $d1Success = $this->testD1();
        $this->newLine();
        $r2PublicSuccess = $this->testR2Public();
        $this->newLine();
        $r2PrivateSuccess = $this->testR2Private();
        $this->newLine();

        if ($d1Success && $r2PublicSuccess && $r2PrivateSuccess) {
            $this->info('✔ All Cloudflare tests passed successfully!');

            return Command::SUCCESS;
        }

        $this->error('✖ Some Cloudflare tests failed. Review the output above.');

        return Command::FAILURE;
    }

    protected function testD1(): bool
    {
        $this->line('<fg=cyan;options=bold>1. Cloudflare D1 Database Connection</>');
        $connection = config('database.default');
        $this->line("   Active DB Connection: <fg=yellow>{$connection}</>");

        try {
            $tables = DB::connection('d1')->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            $count = count($tables);
            $this->info("   ✔ Successfully connected to Cloudflare D1! Found {$count} table(s).");

            if ($count > 0) {
                $tableNames = array_map(fn ($t) => is_object($t) ? ($t->name ?? current((array) $t)) : $t['name'], $tables);
                $this->line('   Tables: '.implode(', ', array_slice($tableNames, 0, 10)).($count > 10 ? '...' : ''));
            }

            return true;
        } catch (\Throwable $e) {
            $this->error('   ✖ Failed to connect or query Cloudflare D1: '.$e->getMessage());

            return false;
        }
    }

    protected function testR2Public(): bool
    {
        $this->line('<fg=cyan;options=bold>2. Cloudflare R2 Public Object Storage (Articles, Media, Images)</>');
        $bucket = config('filesystems.disks.r2.bucket');
        $this->line("   Target Bucket: <fg=yellow>{$bucket}</>");

        try {
            $testFileName = 'cloudflare-test/public-'.Str::random(16).'.txt';
            $testContent = 'SPPrototype Public R2 connection verified at '.now()->toIso8601String();

            $this->line("   Attempting to write test file: {$testFileName}...");
            Storage::disk('r2')->put($testFileName, $testContent, 'public');

            $exists = Storage::disk('r2')->exists($testFileName);
            if (! $exists) {
                throw new \Exception('File was uploaded but could not be verified on public R2 bucket.');
            }

            $url = Storage::disk('r2')->url($testFileName);
            $this->info('   ✔ Public file successfully written and verified on Cloudflare R2!');
            $this->line("   Public CDN URL: <fg=blue>{$url}</>");

            Storage::disk('r2')->delete($testFileName);
            $this->info('   ✔ Test file successfully cleaned up.');

            return true;
        } catch (\Throwable $e) {
            $this->error('   ✖ Failed Cloudflare R2 public bucket operation: '.$e->getMessage());

            return false;
        }
    }

    protected function testR2Private(): bool
    {
        $this->line('<fg=cyan;options=bold>3. Cloudflare R2 Private Object Storage (Protected Downloads, Signed URLs)</>');
        $bucket = config('filesystems.disks.r2-private.bucket');
        $this->line("   Target Bucket: <fg=yellow>{$bucket}</>");

        try {
            $testFileName = 'cloudflare-test/private-'.Str::random(16).'.txt';
            $testContent = 'SPPrototype Private R2 signed URL verified at '.now()->toIso8601String();

            $this->line("   Attempting to write private file: {$testFileName}...");
            Storage::disk('r2-private')->put($testFileName, $testContent, 'private');

            $exists = Storage::disk('r2-private')->exists($testFileName);
            if (! $exists) {
                throw new \Exception('Private file was uploaded but could not be verified on private R2 bucket.');
            }

            $signedUrl = Storage::disk('r2-private')->temporaryUrl($testFileName, now()->addMinutes(15));
            $this->info('   ✔ Private file written and Temporary S3 Presigned URL generated successfully!');
            $this->line("   Presigned URL (Valid 15m): <fg=blue>{$signedUrl}</>");

            Storage::disk('r2-private')->delete($testFileName);
            $this->info('   ✔ Private test file successfully cleaned up.');

            return true;
        } catch (\Throwable $e) {
            $this->error('   ✖ Failed Cloudflare R2 private bucket operation: '.$e->getMessage());

            return false;
        }
    }
}
