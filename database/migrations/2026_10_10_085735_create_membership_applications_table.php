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
        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('membership_type');
            $table->string('application_type')->default('New Application');
            $table->string('application_date');
            $table->string('recommender_name')->nullable();
            $table->string('recommender_email')->nullable();
            $table->string('recommender_suffix')->nullable();
            $table->string('alt_recommender_name')->nullable();
            $table->string('alt_recommender_email')->nullable();
            $table->string('alt_recommender_suffix')->nullable();
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('sex')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('nationality')->nullable();
            $table->text('home_address')->nullable();
            $table->string('current_affiliation')->nullable();
            $table->string('current_position')->nullable();
            $table->string('institutional_email')->nullable();
            $table->string('highest_educational_attainment')->nullable();
            $table->string('degree')->nullable();
            $table->string('date_degree_obtained')->nullable();
            $table->string('institution_name')->nullable();
            $table->text('institution_address')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('proof_path')->nullable();
            $table->boolean('declaration_agree')->default(true);
            $table->boolean('certification_confirm')->default(true);
            $table->string('account_email');
            $table->string('status')->default('Under Evaluation');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_applications');
    }
};
