<?php

namespace App\Http\Controllers;

use App\Models\Musica;
use Illuminate\Http\Request;

class MusicaController extends Controller
{
    public function index()
    {
        $musicas = Musica::orderBy('visualizacoes', 'desc')->take(5)->get();
    
        return response()->json([
            'status' => 'success',
            'data' => $musicas
        ]);
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => ['required', 'url', function ($attribute, $value, $fail) {
                if (!preg_match('/(?:youtube\.com|youtu\.be)/', $value)) {
                    $fail('The URL must be a valid YouTube link.');
                }
            }]
        ]);
        

        $videoId = $this->extractVideoId($validated['url']);
        $videoInfo = $this->getVideoInfo($videoId);

        $musica = Musica::create($videoInfo);

        return response()->json(['message' => 'Música cadastrada com sucesso!', 'data' => $musica], 201);
    }

    private function extractVideoId($url)
    {
        preg_match('/(?:youtube\.com.*(?:\/|v=)|youtu\.be\/)([^&?]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    private function getVideoInfo($videoId)
    {
        $url = "https://www.youtube.com/watch?v=$videoId";

        try {
            $response = @file_get_contents($url);
            if ($response === false) {
                throw new \Exception('Unable to fetch video details.');
            }

            if (preg_match('/<title>(.+?) - YouTube<\/title>/', $response, $matches)) {
                $title = htmlspecialchars_decode($matches[1], ENT_QUOTES);
            } else {
                throw new \Exception('Video title not found.');
            }

            $thumb = "https://img.youtube.com/vi/$videoId/hqdefault.jpg";
            return ['titulo' => $title, 'youtube_id' => $videoId, 'thumb' => $thumb, 'visualizacoes' => 0];
        } catch (\Exception $e) {
            throw new \Exception('Error fetching video info: ' . $e->getMessage());
        }
    }

}
