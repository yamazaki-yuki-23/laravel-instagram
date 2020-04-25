@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="col-4">
            <div class="card">
                <div class="d-flex align-items-center">
                    <div class="pr-3 ml-2 mt-2">
                        <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 40px;">
                    </div>
                    <div>
                        <div class="font-weight-bold row mt-2">
                            <a class="ml-2 card-link" href="/profile/{{ $post->user->id }}">
                                <span class="text-dark">{{ $post->user->username }}</span>
                            </a>
                            @if(Auth::id() != $post->user->id)
                                <follow-button user-id="{{ $post->user->id }}" follows="{{ $follows }}"></follow-button>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                <p>
                    <span class="font-weight-bold ml-2">
                        <a class="card-link" href="/profile/{{ $post->user->id }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </span> {{ $post->caption }}
                </p>

                <div class="px-2 overflow-auto" id="comment-post-{{ $post->id }}" style="max-height:250px;">
                    @include('posts.comment_list')
                </div>

                <hr>

                <div class="card-body px-0">
                    <div class="row parts px-2">
                        <div id="like-icon-post-{{ $post->id }}">
                            <like-button post-id="{{ $post->id }}" user-id="{{ Auth::user()->id }}" likes="{{ ($post->likedBy(Auth::user())->first()) ? true : false }}"></like-button>
                        </div>
                        <a class="comment" href="javascript:focusMethod();"></a>
                    </div>
                    <div id="like-text-post-{{ $post->id }}">
                        @include('posts.like_text')
                    </div>

                    <hr>

                    <div class="row actions px-3" id="comment-form-post-{{ $post->id }}">
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
@endsection


<script type="text/javascript">
    function focusMethod(){
        document.getElementById("textField").focus();
    }
</script>
