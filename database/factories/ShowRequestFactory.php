<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShowRequest>
 */
class ShowRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->company,
            'email' => $this->faker->email,
            'date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'whatsapp' => $this->faker->phoneNumber,
            'eventname' => $this->faker->sentence,
            'location' => $this->faker->address,
            'notes' => $this->faker->paragraph,
            'status' => $this->faker->randomElement([0, 1, 2]),
        ];
    }
}
