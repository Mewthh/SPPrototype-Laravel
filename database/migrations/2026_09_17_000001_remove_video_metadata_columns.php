<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove fields that are no longer part of the video resource editor.
     */
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['description', 'content_type']);
        });
    }

    /**
     * Restore the removed fields when rolling back.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->enum('content_type', ['video', 'webinar'])->default('video')->after('video_url');
        });
    }
};
