<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\support\Facades\DB;
use Illuminate\support\Facades\Storage;
use Illuminate\support\Facades\File;
use App\Models\User;
use App\Models\Image;
use App\Models\Follow;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index($search = null){
        if(!empty($search) && !is_null($search)){
            $users = User::where("nick","LIKE","%$search%")
                                ->orWhere("name","LIKE","%$search%")
                                ->orWhere("surname","LIKE","%$search%")
                                ->orderBy("id","desc")->paginate(5);
        }
        else{
            $users = User::orderBy("id","desc")->paginate(5);
        }

        return view('user.index', [
            'paginator' => $users,
            'title' => "Usuarios",
            'users' => $users
        ]);
    }

    public function config(){
        return view("user.config");
    }

    public function update(Request $request){

        $userID = \Auth::user()->id;

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$userID,
            'email' => 'required|string|email|max:255|unique:users,email,'.$userID,
        ]);

        if($image_path = $request->file('image_path')){
            $image_path_full = time().$image_path->getClientOriginalName();
            Storage::disk('users')->put($image_path_full, File::get($image_path));
        }

        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        DB::table("users")->where("id","=",$userID)->update([
            "name" => $name,
            "surname" => $surname,
            "nick" => $nick,
            "email" => $email,
            "image" => $image_path_full
        ]);
        
        return redirect()->action('App\Http\Controllers\UserController@config');
    }

    public function getImage($fileName){
        $file = Storage::disk('users')->get($fileName);
        return new Response($file,200);
    }

    public function deleteImage(Request $request){
        $user = \Auth::user();
        $image_id = $request->image_id;
        if(isset($image_id) && $image = Image::where('id',$image_id)->get()->get(0)){
            //no se puede eliminar por FK
            Image::where('id',$image_id)->delete();
            $file = Storage::disk('images')->delete($image->image_path);
            return response()->json([
                'message' => True
            ]);
        }
        else
            return response()->json([
                'message' => false
            ]);
    }

    public function profile($user_id){
        $user = User::where('id',$user_id)->get();
        $images = Image::where('user_id',$user_id)->paginate(5);

        return view('dashboard', [
            'images' => $images,
            'paginator' => $images,
            'title' => "Perfil de @" . $user->get(0)->nick,
            'user' => $user->get(0)
        ]);
    }

    public function followings(){
        $user = \Auth::user();
        $follows = Follow::where("follower_id",$user->id)->paginate(5);
        $users = [];
        
        foreach($follows as $follow){
            $users[] = User::where('id',$follow->following_id)->get()->get(0);
        }
        
        return view('user.index', [
            'users' => $users,
            'paginator' => $follows,
            'title' => "Seguidores"
        ]);
    }

    public function chat(){
        
        return view('user.chat');
    }
    
}
