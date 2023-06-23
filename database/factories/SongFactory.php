<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            //
            'title' => 'Tamiang Meulit Kana Bitis',
            'slug' => 'tamiang-meulit-kana-bitis',
            'link' => 'https://open.spotify.com/track/3QNHskNc5uQa2vzHt7SpGu?si=56fb335b01924049',
            'release_date' => $this->faker->dateTimeInInterval(),
            'album' => '0',
            'lyrics' => collect($this->faker->paragraphs(mt_rand(5,10)))->map(fn ($p) => "<p>$p</p>")->implode(''),

        ];
    }
}
