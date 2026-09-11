<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('download_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->timestamps();
        });

        $timestamp = now();
        DB::table('download_categories')->insert(array_map(
            fn (string $name): array => ['name' => $name, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            [
                'Conference Handbooks',
                'Backdrops for Online Talks',
                'PASUC Endorsement',
                'DepEd Advisory',
                'CHEd Endorsement',
            ],
        ));
    }

    public function down(): void
    {
        Schema::dropIfExists('download_categories');
    }
};
