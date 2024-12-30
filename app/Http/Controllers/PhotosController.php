<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Photo;
// use Error;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\RateLimiter;
use Throwable;

class PhotosController extends Controller
{
    public function store(Request $req){
        $validator = Validator::make($req->all(),[
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ],[]);

        if($validator->fails())
            return response()->json(['success'=>false,'message'=>$validator->errors()->first() ], 400);

        $ip = $req->ip();
        $executed = RateLimiter::attempt($ip,$perTwoMinutes = 4,function() {});
        if (!$executed)
            return response()->json(['success'=>false, 'message'=>'Demasiadas peticiones. Espere 1 minuto.' ],500);

        try {
            $image = $req->file('image');
            $imager = new ImageManager(Driver::class);
            $extension = 'jpg';
            $imageName = 'fot_' . '.' . $extension;

            $eventID = $req->event_id;

            $eventoPremium = Event::find($eventID);
            if(!$eventoPremium){
                return response()->json([
                    'success'=>false,
                    'message'=>'Evento no encontrado'
                ], 404);
            }

            if( ! $eventoPremium->premium){
               $cantidadFremium = Photo::where('event_id',$eventID)->count();
               if($cantidadFremium >= 20){
                   return response()->json([
                       'success'=>false,
                       'message'=>'No puedes subir mas de 20 fotos. Sube a plan mas alto'
                   ], 400);
               }
            }


            $directoryPath = public_path('eventos/' . $eventID);

            // Verifica si la carpeta existe y crea si no
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0755, true);
            }
            $publicPath = $directoryPath . '/' . $imageName;
            $imager->read($image)->scale(800)->save($publicPath);

            $eventoPremium->FotosPorEvento()->create([
                'name' => $imageName,
                'titulo'=>'Foto',
                'url_b'=>$publicPath,
                'url_q'=>$publicPath,
                'url_m'=>$publicPath,
                'host'=>'localhost',
                'extension'=>$extension
            ]);

            return response()->json([
                'success'=>true,
                'results'=>'Foto subida'
            ]);
        } catch (Throwable $th) {
            Log::info($th);
            return response()->json([
                'success'=>false,
                'message'=>'Error al subir la foto. '
            ], 500);
        }
    }

}
