@extends('layouts.app')

@section('content')

<div class="container">
    <div class="infinite-scroll">
        @forelse ($posts as $post)
            <div class="col-8 offset-md-2">
                <div class="card-wrap">
                    <div class="card">
                        <div class="card-header bg-white align-items-center d-flex">
                            <a class="no-text-decoration" href="/profile/{{ $post->user->id }}">
                                @if($post->user->profile->profileImage())
                                    <img class="post-profile-icon round-img" src="data:img/png;base64,{{ $post->user->profile->profileImage() }}">
                                @else
                                    <img class="post-profile-icon round-img" src="/Psy0tMpnjUQIbumb25Csi1XLLdhLV2QWT2R3K4Zh.jpeg">
                                @endif
                            </a>
                            <a class="black-color no-text-decoration" href="/profile/{{$post->user->id }}">
                                <strong>{{  $post->user->username }}</strong>
                            </a>
                            @if($post->user->id == Auth::user()->id)
                                <a class="ml-auto mx-0 my-auto" rel="nofollow" href="/p/{{ $post->id }}/delete" onclick="return confirm('本当に削除してもよろしいですか？');">
                                    <div class="delete-post-icon"></div>
                                </a>
                            @endif
                        </div>

                        <a href="/profile/{{$post->user->id }}">
                            <img src="data:img/png;base64,{{$post->image}}" class="card-img-top" style="max-height:70vh;">
                        </a>


                        <div class="card-body">
                            <div class="row parts">
                                <div id="like-icon-post-{{ $post->id }}">
                                    <like-button post-id="{{ $post->id }}" user-id="{{ Auth::user()->id }}" likes="{{ ($post->likedBy(Auth::user())->first()) ? true : false }}"></like-button>
                                </div>
                                <a class="comment" href="/p/{{ $post->id }}"></a>
                            </div>
                            <div id="like-text-post-{{ $post->id }}">
                                @include('posts.like_text')
                            </div>
                            <div>
                                <span><strong>{{ $post->user->username }}</strong></span>
                                <span>{{ $post->caption }}</span>

                                <div class="overflow-auto mt-2" id="comment-post-{{ $post->id }}" style="max-height:200px;">
                                    @include('posts.comment_list')
                                </div>
                                <a class="light-color post-time no-text-decoration" href="/p/{{ $post->id }}">{{ $post->created_at }}</a>
                                <hr>
                                <div class="row actions" id="comment-form-post-{{ $post->id }}">
                                    <form class="w-100" id="new_comment" action="/comments/{{ $post->id }}" accept-charset="UTF-8" data-remote="true" method="post">
                                        <input type="hidden" name="utf8" value="&#x2713;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <add-comment></add-comment>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        @empty
            <div class="col-8 offset-md-2">
                <div class="card-wrap">
                    <h4 class="text-center pt-5">まだ投稿がありません</h4><br>
                    <p class="text-center"><a class="card-link" href="/p/create">投稿する場合はこちら</a></p>
                </div>
            </div>
        @endforelse

        {{ $posts->links() }}

    </div>


</div>


@endsection
