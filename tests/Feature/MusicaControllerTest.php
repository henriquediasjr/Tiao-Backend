<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Musica;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeatureMusicaControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_store_saves_valid_youtube_link()
    {

        $validUrl = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        $response = $this->postJson('/api/sugerir', ['url' => $validUrl]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'message',
                    'data' => ['id', 'titulo', 'youtube_id', 'thumb', 'visualizacoes', 'created_at', 'updated_at'],
                ]);

    }


    public function test_store_rejects_invalid_youtube_link()
    {
        $invalidUrl = 'https://example.com';

        $response = $this->postJson('/api/sugerir', ['url' => $invalidUrl]);

        $response->assertStatus(422); // Unprocessable Entity
    }
}
