<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Profile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditProfoleRequest;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(User $user)
    {
        //ログインユーザーがフォローしているか否かを確認
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        //フォローしていないユーザー
        $exclude_id = $this->search_unfollower_users();
        $unfollow_users = User::whereNotIn('id', $exclude_id)->paginate(5);
        // dd($user->following);exit;

        //投稿記事の取得
        $posts = Post::where('user_id', $user->id)->latest()->paginate(9);

        //投稿数のカウント
        $postCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addSeconds(10),
            function () use ($user) {
                return $user->posts->count();
            });

        //フォロー数のカウント
        $followersCount = Cache::remember(
            'count.followers' . $user->id,
            now()->addSeconds(10),
            function () use ($user) {
                return $user->profile->followers->count();
            });

        //フォロワー数のカウント
        $followingCount = Cache::remember(
            'count.following.' . $user->id,
            now()->addSeconds(10),
            function () use ($user) {
                return $user->following->count();
            });
        return view('profiles.index', compact('user', 'unfollow_users', 'posts', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(EditProfoleRequest $req, User $user)
    {
        $this->authorize('update', $user->profile);

        $data = $req->all();

        if(request('image')) {
            // $imagePath = request('image')->store('profile', 'public');
            // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            // $image->save();
            $image = base64_encode(file_get_contents(request('image')->getRealPath()));

            $imageArray = ['image' => $image];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect("/profile/{$user->id}")->with('flash_message', 'プロフィールの変更が完了しました');
    }

    protected function search_unfollower_users(){
        $followers_id = auth()->user()->profile->followers->pluck('id')->toArray();
        $follow_user_id = auth()->user()->following()->pluck('profiles.user_id')->toArray();
        $exclude_id = array_merge($follow_user_id, $followers_id);
        $exclude_id[] = Auth::id();
        return $exclude_id;
    }
}
