<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\support\Facades\DB;
use Illuminate\support\Facades\Storage;
use Illuminate\support\Facades\File;
use App\Models\Image;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function save(Request $request){

        $request->validate([
            'description' => 'required',
            'image_path' => 'required|image'
        ]);

        $description = $request->input('description');

        if($image_path = $request->file('image_path')){
            $image_path_full = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_full, File::get($image_path));
        }

        $image = new Image();
        $image->user_id = \Auth::user()->id;
        $image->image_path = $image_path_full;
        $image->description = $description;

        $image->save();

        return redirect()->route('dashboard')->with([
            'message' => "La foto se ha subido correctamente"
        ]);
    }

    public function getImage($fileName){
        $file = Storage::disk('images')->get($fileName);
        return new Response($file,200);
    }

}
