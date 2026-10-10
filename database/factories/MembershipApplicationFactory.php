<?php

namespace Database\Factories;

use App\Models\MembershipApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MembershipApplication>
 */
class MembershipApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'membership_type' => fake()->randomElement(['Regular Member', 'Associate Member', 'Institutional Member']),
            'application_type' => 'New Application',
            'application_date' => now()->format('m/d/Y'),
            'recommender_name' => fake()->name(),
            'recommender_email' => fake()->safeEmail(),
            'recommender_suffix' => null,
            'alt_recommender_name' => null,
            'alt_recommender_email' => null,
            'alt_recommender_suffix' => null,
            'surname' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'suffix' => null,
            'mobile_number' => fake()->phoneNumber(),
            'birthdate' => fake()->date('Y-m-d'),
            'sex' => fake()->randomElement(['Male', 'Female']),
            'civil_status' => fake()->randomElement(['Single', 'Married']),
            'nationality' => 'Filipino',
            'home_address' => fake()->address(),
            'current_affiliation' => fake()->company(),
            'current_position' => fake()->jobTitle(),
            'institutional_email' => fake()->companyEmail(),
            'highest_educational_attainment' => 'Ph.D.',
            'degree' => 'Doctor of Philosophy in Physics',
            'date_degree_obtained' => fake()->date('m/d/Y'),
            'institution_name' => fake()->company(),
            'institution_address' => fake()->city(),
            'cv_path' => null,
            'proof_path' => null,
            'declaration_agree' => true,
            'certification_confirm' => true,
            'account_email' => fake()->unique()->safeEmail(),
            'status' => 'Under Evaluation',
            'remarks' => null,
        ];
    }
}
