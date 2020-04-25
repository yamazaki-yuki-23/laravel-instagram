<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Post;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Post $post)
    {
        //likeテーブルに追加する
        $like =  new Like();
        $like->post_id = $post->id;
        $like->user_id = Auth::id();
        $like->save();

        //該当記事の総いいね数をカウント
        // return response()->json(['likeCount' => $likeCount]);
    }

    public function destroy(Post $post)
    {
        //likeテーブルから該当ユーザーのいいねを取り消す
        $like = Like::where('post_id', $post->id)->where('user_id', Auth::id())->first();
        $like->delete();
    }
}
