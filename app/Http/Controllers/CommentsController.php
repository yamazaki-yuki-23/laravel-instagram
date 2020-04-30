<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Post;
use App\Rules\CommentRule;

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
            'post_id' => 'required',
        ]);

        auth()->user()->comments()->create([
            'comment' => $data['comment'],
            'post_id' => $data['post_id'],
            'user_id' => auth()->user()->id,
        ]);
        $comments = Comment::where('post_id', $data['post_id'])->with('user')->get();
        return $comments;
    }

    public function delete(Request $request)
    {
        Comment::find($request->comment_id)->delete();
        $comments = Comment::where('post_id', $request->post_id)->with('user')->get();
        return $comments;
    }

    public function get(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)->with('user')->get();
        return $comments;
    }

}
