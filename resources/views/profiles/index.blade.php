@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h2 mr-4">{{ $user->username }}</div>
                    @if(Auth::id() != $user->id)
                        <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                    @endif
                </div>

                @can('update', $user->profile)
                    <a class="btn btn-outline-dark btn-sm edit-profile-btn" href="/p/create">新規投稿</a>
                @endcan
            </div>
            @can('update', $user->profile)
                <div class="mb-3">
                    <a class="btn btn-outline-dark btn-sm edit-profile-btn" href="/profile/{{ $user->id }}/edit">プロフィールを編集</a>
                    <a class="ml-3 btn btn-outline-dark btn-sm edit-profile-btn" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        ログアウト
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endcan

            <div class="d-flex">
                <div class="pr-5">投稿<strong>{{ $postCount }}</strong>件</div>
                <div class="pr-5">
                    <a class="text-dark card-link" href="#" data-toggle="modal" data-target="#followersModalLong">
                        フォロワー<strong>{{ $followersCount }}</strong>人
                    </a>
                </div>
                <div class="pr-5">
                    <a class="text-dark card-link" href="#" data-toggle="modal" data-target="#followsModalLong">
                        フォロー中<strong>{{ $followingCount }}</strong>人
                    </a>
                </div>
            </div>
            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a class="card-link" href="{{ $user->profile->url }}">{{ $user->profile->url }}</a></div>
        </div>
    </div>

    <div class="modal fade" id="followersModalLong" tabindex="-1" role="dialog" aria-labelledby="followersModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="followersModalLongTitle">フォロワー</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($user->profile->followers->count() > 0)
                        @foreach($user->profile->followers as $follower)
                            @inject('imagePath', 'App\Services\FollowerGetImage')
                            <div class="row">
                                <div class="col-3 px-5 pb-3">
                                    <a href="/profile/{{ $follower->id }}">
                                        <img src="{{ $imagePath->getImagePath($follower->id)->profileImage() }}" class="rounded-circle w-100">
                                    </a>
                                </div>

                                <div class="col-9">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <div class="col-md-5">
                                            <div class="p">{{ $follower->username }}</div>
                                        </div>
                                        <div class="col-md-5 float-right mr-2">
                                            <follow-button user-id="{{ $follower->id }}" follows="{{ $follows }}"></follow-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center">
                            <span aria-label="フォロワー" class="glyphsSpriteAdd_friend__outline__96 u-__7"></span>
                            <h4 class="pt-2">フォロワー</h4>
                            <p>ここにすべてのフォロワーが表示されます。</p>
                        </div>
                    @endif
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLongTitle">おすすめ</h5>
                    @if($unfollow_users->count() > 0)
                        @foreach($unfollow_users as $unfollow_user)
                            @inject('imagePath', 'App\Services\FollowerGetImage')
                            @inject('followPath', 'App\Services\ConfirmFollow')
                            <div class="row">
                                <div class="col-3 px-5 pb-3">
                                    <a href="/profile/{{ $unfollow_user->id }}">
                                        <img src="{{ $imagePath->getImagePath($unfollow_user->id)->profileImage() }}" class="rounded-circle w-100">
                                    </a>
                                </div>

                                <div class="col-9">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <div class="col-md-5">
                                            <div class="p">{{ $unfollow_user->username }}</div>
                                        </div>
                                        <div class="col-md-5 float-right mr-2">
                                            <follow-button user-id="{{ $unfollow_user->id }}" follows="{{ $followPath->confirm($unfollow_user->id, $user) }}"></follow-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center">
                            <p　class="pt-3">現在、あなたにおすすめのユーザーはございません。</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="followsModalLong" tabindex="-1" role="dialog" aria-labelledby="followsModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="followsModalLongTitle">フォロー中</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <sapn aria-hidden="true">&times;</sapn>
                    </button>
                </div>
                <div class="modal-body">
                    @if($user->following->count() > 0)
                        @foreach($user->following as $follow)
                        @inject('followPath', 'App\Services\ConfirmFollow')
                            <div class="row">
                                <div class="col-3 px-5 pb-3">
                                    <a href="/profile/{{ $follow->user_id }}">
                                        <img src="{{ $follow->profileImage() }}" class="rounded-circle w-100">
                                    </a>
                                </div>

                                <div class="col-9">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <div class="col-md-5">
                                            <div class="p">{{ $follow->title }}</div>
                                        </div>
                                        <div class="col-md-5 float-right mr-2">
                                            <follow-button user-id="{{ $follow->user_id }}" follows="{{ $followPath->confirm($follow->user_id, $user) }}"></follow-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center">
                            <span aria-label="フォロワー" class="glyphsSpriteAdd_friend__outline__96 u-__7"></span>
                            <h4 class="pt-2">フォロワー</h4>
                            <p>ここにすべてのフォロワーが表示されます。</p>
                        </div>
                    @endif
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLongTitle">おすすめ</h5>
                    @if($unfollow_users->count() > 0)
                        @foreach($unfollow_users as $unfollow_user)
                            @inject('imagePath', 'App\Services\FollowerGetImage')
                            @inject('followPath', 'App\Services\ConfirmFollow')
                            <div class="row">
                                <div class="col-3 px-5 pb-3">
                                    <a href="/profile/{{ $unfollow_user->id }}">
                                        <img src="{{ $imagePath->getImagePath($unfollow_user->id)->profileImage() }}" class="rounded-circle w-100">
                                    </a>
                                </div>

                                <div class="col-9">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <div class="col-md-5">
                                            <div class="p">{{ $unfollow_user->username }}</div>
                                        </div>
                                        <div class="col-md-5 float-right mr-2">
                                            <follow-button user-id="{{ $unfollow_user->id }}" follows="{{ $followPath->confirm($unfollow_user->id, $user) }}"></follow-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center">
                            <p　class="pt-3">現在、あなたにおすすめのユーザーはございません。</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="infinite-scroll pt-5">
        <div class="row">
        @foreach($posts as $post)
            <div class="col-4 pt-4">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100">
                </a>
            </div>
        @endforeach
        {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
