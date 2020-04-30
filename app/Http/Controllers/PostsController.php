<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Tag;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreatePostRequest;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
        $users[] = Auth::id();
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);
        //おすすめのユーザーを取得する
        $recommend_users = User::whereNotIn('id', [$users])->get();
        foreach($recommend_users as $recommend_user){
            $recommend_user['follow'] = $recommend_user->following->contains($recommend_user->id);
        }

        return view('posts.index', compact('posts', 'recommend_users'));
    }

    public function show(Post $post)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($post->user_id) : false;
        return view('posts.show', compact('post', 'follows'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(CreatePostRequest $req)
    {
        $data = $req->all();

        // $image_path = request('image')->store('uploads', 'public');
        // $image = Image::make(public_path("storage/{$image_path}"))->fit(1200, 1200);
        $image = base64_encode(file_get_contents(request('image')->getRealPath()));
        // $image->save();

        $post =  auth()->user()->posts()->create([
            'caption' => $data['caption'],
            // 'image'   => $image_path,
            'image'   => $image,
        ]);

        //タグの登録
        if($data['tags']) {
            $tags_id = $this->format_tag($data['tags']);
            $post->tags()->attach($tags_id); //　投稿にタグ付けするために、attachメソッドを使い、モデルを結びつけている中間テーブルにレコードを挿入する。
        }

        return redirect('/profile/'. auth()->user()->id)->with('flash_message', '投稿が完了しました');
    }


    public function delete($post_id)
    {
        Post::find($post_id)->delete();
        Comment::where('post_id',$post_id)->delete();
        \DB::table('post_tag')->where('post_id', $post_id)->delete();
        return redirect('/')->with('flash_message', '削除されました');
    }

    private function format_tag($tags)
    {
        $tags = str_replace("、", ",", $tags);
        $array_tags = explode(",", $tags);
        $tags = [];
        foreach($array_tags as  $tag) {
            if(substr($tag, 0, 1) !==  "#") {
                $tag = "#".$tag;
            }
            // #(ハッシュタグ)で始まる単語を取得。結果は、$matchに多次元配列で代入される。
            preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $tag, $match);
            // $match[0]に#(ハッシュタグ)あり、$match[1]に#(ハッシュタグ)なしの結果が入ってくるので、$match[1]なしの結果のみを使用
            $record = Tag::firstOrCreate(['name' => $match[1][0]]);
            array_push($tags, $record);
        }

        // 投稿に紐づけされるタグのidを配列化
        $tags_id = [];
        foreach($tags as $tag) {
            array_push($tags_id, $tag['id']);
        };

        return $tags_id;
    }
}
