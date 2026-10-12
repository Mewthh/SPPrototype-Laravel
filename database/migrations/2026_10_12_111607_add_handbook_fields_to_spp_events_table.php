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
        Schema::table('spp_events', function (Blueprint $table) {
            $table->string('handbook_name')->nullable()->after('image');
            $table->string('handbook_file')->nullable()->after('handbook_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spp_events', function (Blueprint $table) {
            $table->dropColumn(['handbook_name', 'handbook_file']);
        });
    }
};
