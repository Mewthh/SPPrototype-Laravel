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
        $r2Success = $this->testR2();
        $this->newLine();

        if ($d1Success && $r2Success) {
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

    protected function testR2(): bool
    {
        $this->line('<fg=cyan;options=bold>2. Cloudflare R2 Object Storage</>');
        $disk = config('filesystems.default');
        $this->line("   Active Storage Disk: <fg=yellow>{$disk}</>");

        try {
            $testFileName = 'cloudflare-test/'.Str::random(16).'.txt';
            $testContent = 'SPPrototype Cloudflare R2 connection verified at '.now()->toIso8601String();

            $this->line("   Attempting to write test file: {$testFileName}...");
            Storage::disk('r2')->put($testFileName, $testContent, 'public');

            $exists = Storage::disk('r2')->exists($testFileName);
            if (! $exists) {
                throw new \Exception('File was uploaded but could not be verified on R2.');
            }

            $url = Storage::disk('r2')->url($testFileName);
            $this->info('   ✔ File successfully written and verified on Cloudflare R2!');
            $this->line("   Public / Resolved URL: <fg=blue>{$url}</>");

            Storage::disk('r2')->delete($testFileName);
            $this->info('   ✔ Test file successfully cleaned up from Cloudflare R2.');

            return true;
        } catch (\Throwable $e) {
            $this->error('   ✖ Failed Cloudflare R2 operation: '.$e->getMessage());

            return false;
        }
    }
}
