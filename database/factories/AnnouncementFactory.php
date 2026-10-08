<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'target_audience' => fake()->randomElement(['all', 'regular', 'associate', 'institutional']),
            'summary' => fake()->sentence(12),
            'content' => fake()->paragraphs(3, true),
            'status' => 'published',
        ];
    }

    /**
     * Indicate that the announcement is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => 'draft',
        ]);
    }

    /**
     * Indicate that the announcement is archived.
     */
    public function archived(): static
    {
        return $this->state(fn () => [
            'status' => 'archived',
        ]);
    }
}
