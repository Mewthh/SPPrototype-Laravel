<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proceedings_templates', function (Blueprint $table) {
            $table->boolean('first_opens_in_new_tab')->default(true)->after('first_url');
            $table->boolean('second_opens_in_new_tab')->default(true)->after('second_url');
        });
    }

    public function down(): void
    {
        Schema::table('proceedings_templates', function (Blueprint $table) {
            $table->dropColumn(['first_opens_in_new_tab', 'second_opens_in_new_tab']);
        });
    }
};
