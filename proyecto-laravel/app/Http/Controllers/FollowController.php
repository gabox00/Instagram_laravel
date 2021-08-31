<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Follow;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function follow($following_id){
        $follower_id = \Auth::user()->id;

        $follow = new Follow();
        $follow->follower_id = $follower_id;
        $follow->following_id = $following_id;
        $follow->save();

        return response()->json([
            'message' => "follow success!"
        ]);
    }

    public function unfollow($following_id){
        $follower_id = \Auth::user()->id;

        Follow::where("follower_id",$follower_id)->where("following_id",$following_id)->delete();

        return response()->json([
            'message' => "unfollow success!"
        ]);
    }
}
