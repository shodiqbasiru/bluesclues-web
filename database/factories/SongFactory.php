<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        $slug = Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 9999);;

        return [
            'title' => $title,
            'slug' => $slug,
            'image' => "songs-images/BbVBFkyXkW8FRQM01meeLwTV1Em3lkrwIyN1BNRq.png",
            'link' => $this->faker->url,
            'album' => $this->faker->word,
            'release_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'lyrics' => $this->faker->paragraph,
        ];
    }
}
