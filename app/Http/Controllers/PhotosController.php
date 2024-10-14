<?php

namespace App\Http\Controllers;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;


class PhotosController extends Controller
{
    public function store(Request $req){
        $validator = Validator::make($req->all(),[
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ],[]);

        if($validator->fails())
            return response()->json(['success'=>false,'message'=>$validator->errors()->first() ], 400);

        try {
            $image = $req->file('image');
            $imager = new ImageManager(Driver::class);
            $extension = 'jpg';
            $imageName = 'fot_' . '.' . $extension;

            $eventID = $req->event_id;
            $directoryPath = public_path('eventos/' . $eventID);

            // Verifica si la carpeta existe y crea si no
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0755, true);
            }
            $publicPath = $directoryPath . '/' . $imageName;
            $imager->read($image)->scale(800)->save($publicPath);

            return response()->json([
                'success'=>true,
                'results'=>'a'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);
        }
    }

}
