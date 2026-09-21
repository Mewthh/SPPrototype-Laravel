<?php

namespace Database\Factories;

use App\Models\MembershipFaq;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MembershipFaq> */
class MembershipFaqFactory extends Factory
{
    public function definition(): array
    {
        return ['question' => fake()->sentence(), 'answer' => fake()->paragraph(), 'is_visible' => true, 'sort_order' => 1];
    }
}
