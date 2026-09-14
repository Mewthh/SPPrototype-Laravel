<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('introduction');
            $table->string('council_heading');
            $table->json('officers');
            $table->json('councilors')->nullable();
            $table->string('address', 1000);
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
