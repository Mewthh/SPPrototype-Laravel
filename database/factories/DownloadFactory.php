<?php

namespace Database\Factories;

use App\Models\Download;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Download>
 */
class DownloadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->sentence(),
            'category' => fake()->word(),
            'year' => (int) fake()->year(),
            'file_url' => fake()->url(),
            'file_name' => fake()->word().'.pdf',
            'status' => 'published',
        ];
    }
}
