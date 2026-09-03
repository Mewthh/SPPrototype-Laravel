<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('link_type', 30)->nullable()->after('image');
            $table->string('link_url', 1000)->nullable()->after('link_type');
            $table->unsignedBigInteger('link_target_id')->nullable()->after('link_url');
            $table->boolean('open_in_new_tab')->default(false)->after('link_target_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['link_type', 'link_url', 'link_target_id', 'open_in_new_tab']);
        });
    }
};
