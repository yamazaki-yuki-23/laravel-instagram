@foreach($post->comments as $comment)
    <div class="mt-1">
        @if($comment->user->id == Auth::user()->id)
            <a class="delete-comment" data-remote="true" rel="nofollow" data-method="delete" href="/comments/{{ $comment->id }}"></a>
        @endif
        <span>
            <strong>
                <a class="no-text-decoration black-color" href="/profile/{{ $comment->user_id }}">{{ $comment->user->username }}</a>
            </strong>
        </span>
        <span>{{ $comment->comment }}</span>
    </div>
@endforeach
