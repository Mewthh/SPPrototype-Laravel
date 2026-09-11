<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proceedings_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Proceedings Template');
            $table->string('image', 500)->nullable();
            $table->string('first_label')->nullable();
            $table->string('first_url', 500)->nullable();
            $table->string('second_label')->nullable();
            $table->string('second_url', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceedings_templates');
    }
};
