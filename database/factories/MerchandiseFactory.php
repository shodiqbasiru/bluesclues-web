<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Merchandise>
 */
class MerchandiseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $price = $this->faker->numberBetween(1, 57) * 10000;
        $name = $this->faker->word;
        $slug = Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999);
        return [
            'name' => $name,
            'slug' => $slug,
            'image' => 'merchandise-images/2a75hZBL4R18PGAkrdiFl69BWnBWPzfvgktncDjF.png',
            'description' => $this->faker->paragraph,
            'price' => $price,
            'is_ready' => $this->faker->boolean,
            'category_id' => $this->faker->numberBetween(1,4),
        ];
    }
}
