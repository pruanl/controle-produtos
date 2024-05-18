<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageController extends Controller
{
    public function upload(Request $request){

        $file = $request->file('image');
       #  = $file->store('images');

        #gerar uma string aleatoria com letras e numeros

        $path_save = 'upload/image/' .  date('Ymd');
        $imageName = Str::random(20).'.'.$file->extension();

      #  $imageName = microtime().'.'.$request->image->extension();
        $file->move(public_path($path_save), $imageName);

        $image = Image::create([
            'url' => $path_save .'/'.$imageName,
            'original_name' => $file->getClientOriginalName()
        ]);

        return response()->json(['id' => $image->uuid, 'url' => $image->url], 201);
    }

    public function show($id){
        $image = Image::findOrFail($id);
        $path = public_path($image->url);

        #verifica se path existe
        if(!file_exists($path)){
            return response()->json(['message' => 'Imagem não encontrada'], 404);
        }

        return response()->file($path);
    }
}
