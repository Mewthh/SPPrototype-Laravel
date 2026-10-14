<?php

namespace Database\Factories;

use App\Models\MembershipInquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MembershipInquiry>
 */
class MembershipInquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => 'INQ-'.fake()->unique()->numberBetween(2000, 9999),
            'inquirer_name' => fake()->name(),
            'inquirer_email' => fake()->safeEmail(),
            'inquirer_institution' => fake()->company(),
            'inquirer_tier' => fake()->randomElement(['Regular Member', 'Associate Member', 'Institutional Member']),
            'application_type' => fake()->randomElement(['New Application', 'Membership Renewal', 'Status Upgrade']),
            'query_type' => fake()->randomElement(['Membership Status', 'Request for Certificate of Membership', 'Other']),
            'last_known_membership' => fake()->randomElement(['Regular member', 'Associate member', 'Institutional partner', 'Unknown']),
            'last_attendance_year' => (string) fake()->numberBetween(2018, 2024),
            'last_attendance_place' => fake()->city(),
            'oath_year' => (string) fake()->numberBetween(2015, 2022),
            'oath_venue' => fake()->city(),
            'known_membership_type' => fake()->randomElement(['Regular', 'Associate']),
            'purpose' => fake()->sentence(),
            'keywords' => 'membership, certificate',
            'remarks' => fake()->paragraph(),
            'status' => 'Submitted',
            'priority' => 'Normal',
            'admin_response' => null,
            'certificate_attached' => null,
            'certificate_size' => null,
        ];
    }
}
