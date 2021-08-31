<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request){
        $user = \Auth::user();
        $userId = $user->id;
        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->image_id = $request->image_id;
        $comment->content = $request->content;

        $comment->save();

        return response()->json([
            'userImage' => $user->image,
            'userNick' => $user->nick,
            'commentContent' => $comment->content,
            'commentID' => $comment->id
        ]);
    }

    public function delete(Request $request){
        Comment::where("id", $request->comment_id )->delete();

        return response()->json([
            'message' => "Comentario eliminado correctamente"
        ]);
    }
}
