<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Post;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'comment' => 'required',
        ]);
        auth()->user()->comments()->create([
            'comment' => $data['comment'],
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ]);
        return back()->with('flash_message', 'コメントが追加されました');
    }

    public function delete(Comment $comment)
    {
        Comment::find($comment->id)->delete();
        return back()->with('flash_message', 'コメントが削除されました');
    }

}
