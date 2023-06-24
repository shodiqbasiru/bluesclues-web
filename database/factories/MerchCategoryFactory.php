<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MerchCategory>
 */
class MerchCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $names = ['Apparel', 'Music', 'Accessories', 'Others'];

        return [
            'name' => array_shift($names),
        ];
    }
}
