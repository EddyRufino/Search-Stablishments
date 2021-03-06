<?php

namespace App\Http\Controllers;

use App\Imagen;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'verified']);
    }

    public function store(Request $request)
    {
    	// Leer la imagen
    	$path = $request->file('file')->store('establecimientos', 'public');

		// Resize la imagen
    	$image = Image::make(public_path("storage/{$path}"))->fit(800, 450);
    	$image->save();

    	// Almacenar con modelo
    	$imageDB = new Imagen;
    	$image->id_stablishment = $request['uuid'];
    	$image->path = $path;

    	$imageDB->save();

    	// Retorna respuesta
    	$respuesta = [ 'archivo' => $path ];

        return response()->json($respuesta);
        
    }
}
