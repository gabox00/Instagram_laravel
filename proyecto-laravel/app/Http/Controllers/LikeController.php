<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Http\Response;

class LikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like($image_id){
        $userId = \Auth::user()->id;
        $issetLike = Like::where("user_id", $userId )->where("image_id", $image_id)->count();

        if($issetLike == 0){
            $like = new Like();
            $like->user_id = $userId;
            $like->image_id = $image_id;
    
            $like->save();

            return response()->json([
                'like' => $like
            ]);
        }
        else{
            return response()->json([
                'message' => "El like ya existe"
            ]);
        }
    }

    public function dislike($image_id){
        $userId = \Auth::user()->id;
        $issetLike = Like::where("user_id", $userId )->where("image_id", $image_id)->first();

        if($issetLike){
            Like::where("user_id", $userId )->where("image_id", $image_id)->delete();

            return response()->json([
                'message' => "Eliminado correctamente"
            ]);
        }
        else{
            return response()->json([
                'message' => "El like ya no existe"
            ]);
        }
    }

    public function getLikes(){
        $user_id = \Auth::user()->id;
        $likes = Like::where("user_id",$user_id)->orderBy('id','desc')->paginate(5);
        $images = array();
        foreach ($likes as $like) 
            $images[] = $like->images;
             
        return view('dashboard', [
            'images' => $images,
            'paginator' => $likes,
            'title' => "Fotos favoritas"
        ]);
    }
    
}
