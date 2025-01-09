<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureMusicaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_saves_valid_youtube_link()
    {
        $validUrl = 'https://www.youtube.com/watch?v=exampleId';

        $response = $this->postJson('/api/musicas', ['url' => $validUrl]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'data' => ['id', 'titulo', 'youtube_id', 'thumb', 'visualizacoes', 'created_at', 'updated_at'],
                 ]);

        $this->assertDatabaseHas('musicas', [
            'youtube_id' => 'exampleId',
        ]);
    }

    public function test_store_rejects_invalid_youtube_link()
    {
        $invalidUrl = 'https://example.com';

        $response = $this->postJson('/api/musicas', ['url' => $invalidUrl]);

        $response->assertStatus(422); // Unprocessable Entity
    }
}
