@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-7">
            <img src="data:img/png;base64,{{$post->image}}" class="w-100" style="max-height:70vh;">
        </div>
        <div class="col-5">
            <div class="card">
                <div class="d-flex align-items-center">
                    <div class="pr-3 ml-2 mt-2">
                        @if($post->user->profile->profileImage())
                            <img src="data:img/png;base64,{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 40px;">
                        @else
                            <img src="/Psy0tMpnjUQIbumb25Csi1XLLdhLV2QWT2R3K4Zh.jpeg" class="rounded-circle w-100" style="max-width: 40px;">
                        @endif
                    </div>
                    <div>
                        <div class="font-weight-bold row mt-2">
                            <a class="ml-2 mr-4 mt-2 card-link" href="/profile/{{ $post->user->id }}">
                                <span class="text-dark">{{ $post->user->username }}</span>
                            </a>
                            @if(Auth::id() != $post->user->id)
                                <follow-button user-id="{{ $post->user->id }}" follows="{{ $follows }}"></follow-button>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>
                <div class="card-body">
                    <p>
                        <span class="font-weight-bold">
                            <a class="card-link" href="/profile/{{ $post->user->id }}">
                                <span class="text-dark">{{ $post->user->username }}</span>
                            </a>
                        </span> {{ $post->caption }}
                    </p>

                    <div class="row parts">
                        <div id="like-icon-post-{{ $post->id }}">
                            <like-button
                                post-id="{{ $post->id }}"
                                user-id="{{ Auth::user()->id }}"
                                likes="{{ ($post->likedBy(Auth::user())->first()) ? true : false }}"
                                form-link="show">
                            </like-button>
                        </div>
                    </div>
                    <div id="like-text-post-{{ $post->id }}">
                        @include('posts.like_text')
                    </div>
                    <add-comment post-id="{{ $post->id }}" created_at="{{ $post->created_at }}" user-id="{{ Auth::id() }}"></add-comment>
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
