<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $eventName = $this->faker->sentence;
        $slug = Str::slug($eventName) . '-' . $this->faker->unique()->numberBetween(1, 9999);;

        return [
            'eventname' => $eventName,
            'slug' => $slug,
            'location' => $this->faker->address,
            'time' => $this->faker->time(),
            'date' => $this->faker->date(),
        ];
    }
}
