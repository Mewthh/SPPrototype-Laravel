<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable()->after('event_date');
        });

        DB::table('activities')
            ->where('status', 'scheduled')
            ->whereNotNull('event_date')
            ->update(['published_at' => DB::raw('event_date')]);
    }
};
