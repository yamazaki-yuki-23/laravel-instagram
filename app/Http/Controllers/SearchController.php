<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('search.index');
    }

    public function search(Request $request){
        // return $request;
        $category = $request->category;
        $keyword = $request->keyword;

        if($category == "ユーザー名") {
            $img = [];
            $data = "";
            //投稿者名で記事を絞り込み
            $users = User::where('username', 'LIKE', "%{$keyword}%")->get();
            foreach($users as $user) {
                $img[] = $user->profile->profileImage();
            }
            return $users;
        }else{
            //タグ名で記事を絞り込み
            $posts = [];
            $tag = Tag::where('name', 'LIKE', "%{$keyword}%")->first();
            if(empty($tag)){
                return "";
            }else{
                $posts_tag = \DB::table('post_tag')->where('tag_id', $tag->id)->get();
                foreach($posts_tag as $post_tag) {
                    $posts[] = Post::where('id', $post_tag->post_id)->first();
                }
                return $posts;
            }
        }
    }
}
