<?php

namespace App\Http\Controllers;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;


class PhotosController extends Controller
{
    public function store(Request $req){
        $validator = Validator::make($req->all(),[
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ],[]);

        if($validator->fails())
            return response()->json(['success'=>false,'message'=>$validator->errors()->first() ], 400);

        $image = $req->file('image');

        $imager = new ImageManager(Driver::class);
        $extension = 'jpg';
        $imageName = 'fot_' . '.' . $extension;

        $eventID = $req->event_id;
        $publicPath = public_path('eventos/'.$eventID.'/'. $imageName);
        $imager->read($image)->scale(800)->save($publicPath);

    }

    /* public function upload(Request $request)
    {
        // Validar que la imagen es requerida y es de tipo png o jpg
        $request->validate([
            'image' => 'required|mimes:png,jpg,jpeg|max:2048', // 2MB máximo
        ]);

        // Obtener el archivo de imagen
        $image = $request->file('image');

        // Procesar la imagen (redimensionar, cambiar formato, etc.)
        $img = Image::make($image->getRealPath());

        // Redimensionar la imagen a un ancho de 800px, manteniendo la relación de aspecto
        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        // Guardar la imagen procesada en el almacenamiento local (en la carpeta "public/images")
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $img->save(storage_path('app/public/images/' . $imageName));

        // Retornar respuesta con la URL de la imagen guardada
        $imagePath = asset('storage/images/' . $imageName);

        return response()->json([
            'success' => true,
            'message' => 'Imagen subida exitosamente.',
            'image_url' => $imagePath,
        ], 201);
    } */
}
