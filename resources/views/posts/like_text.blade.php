<strong>
@foreach ($post->likes as $like)
    @if ($loop->count == 1)
      {{ $like->user->username }} </strong> が「いいね！」しました
    @elseif ($loop->last)
      </strong>と<strong>
      {{ $like->user->username }}</strong> が「いいね！」しました
    @elseif (!$loop->first)
      </strong>他{{$loop->remaining + 1}}人が「いいね！」しました
      @break
    @else
      {{ $like->user->username }},
    @endif
@endforeach
</strong>
