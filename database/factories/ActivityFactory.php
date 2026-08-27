<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->randomNumber(4),
            'summary' => fake()->sentence(10),
            'description' => fake()->paragraphs(2, true),
            'image' => null,
            'event_date' => fake()->date(),
            'location' => fake()->city(),
            'status' => 'published',
            'is_featured' => false,
        ];
    }
}
