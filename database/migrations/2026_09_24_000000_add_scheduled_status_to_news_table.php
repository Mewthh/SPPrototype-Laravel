<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! in_array(DB::getDriverName(), ['mariadb', 'mysql'], true)) {
            return;
        }

        Schema::table('news', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft')->change();
        });
    }
};
