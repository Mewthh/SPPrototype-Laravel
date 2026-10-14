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
        Schema::create('membership_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('inquirer_name');
            $table->string('inquirer_email');
            $table->string('inquirer_institution')->nullable();
            $table->string('inquirer_tier')->nullable();
            $table->string('application_type')->nullable();
            $table->string('query_type');
            $table->string('last_known_membership')->nullable();
            $table->string('last_attendance_year')->nullable();
            $table->string('last_attendance_place')->nullable();
            $table->string('oath_year')->nullable();
            $table->string('oath_venue')->nullable();
            $table->string('known_membership_type')->nullable();
            $table->text('purpose')->nullable();
            $table->string('keywords')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('Submitted');
            $table->string('priority')->default('Normal');
            $table->text('admin_response')->nullable();
            $table->string('certificate_attached')->nullable();
            $table->string('certificate_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_inquiries');
    }
};
