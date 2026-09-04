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
            $table->string('year', 10)->nullable()->index()->after('id');
            $table->string('theme', 255)->nullable()->after('title');
            $table->string('dates', 150)->nullable()->after('event_date');
            $table->text('summary')->nullable()->after('dates');
            $table->json('tabs')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spp_events', function (Blueprint $table) {
            $table->dropColumn(['year', 'theme', 'dates', 'summary', 'tabs']);
        });
    }
};
