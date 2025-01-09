<?php

namespace Tests\Feature;

use App\Models\Musica;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitMusicaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_top_5_musicas()
    {
        // Seed the database with test data
        Musica::factory()->count(10)->create();

        // Send a GET request to the index endpoint
        $response = $this->getJson('/api/musicas');

        // Assert the response structure and status
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'data' => [
                         '*' => ['id', 'titulo', 'visualizacoes', 'youtube_id', 'thumb', 'created_at', 'updated_at'],
                     ],
                 ])
                 ->assertJsonCount(5, 'data'); // Ensure only 5 results are returned
    }
}
