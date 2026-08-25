<?php

namespace Database\Factories;

use App\Models\SppEvent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<SppEvent>
 */
class SppEventFactory extends Factory
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
            'description' => fake()->paragraphs(3, true),
            'image' => fake()->imageUrl(),
            'event_date' => fake()->date(),
            'location' => fake()->city(),
            'status' => 'published',
        ];
    }
}
