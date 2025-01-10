<?php

namespace Database\Factories;

use App\Models\Musica;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Musica>
 */
class MusicaFactory extends Factory
{
    protected $model = Musica::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence,
            'visualizacoes' => $this->faker->randomNumber(5),
            'youtube_id' => $this->faker->unique()->word,
            'thumb' => $this->faker->imageUrl(640, 480, 'music', true),
        ];

    }
}
