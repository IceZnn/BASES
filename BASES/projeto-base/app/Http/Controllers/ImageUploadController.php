<?php

namespace App\Http\Controllers;

use App\Services\UploadService;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function store(Request $request, UploadService $uploads)
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'max:4096'],
        ], [
            'image.required' => 'Selecione uma imagem.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.max' => 'A imagem não pode exceder 4 MB.',
        ]);
        $path = $uploads->store($data['image'], 'uploads');

        return response()->json([
            'data' => ['path' => $path, 'url' => $uploads->url($path)],
            'message' => 'Imagem enviada com sucesso.',
        ], 201);
    }
}
