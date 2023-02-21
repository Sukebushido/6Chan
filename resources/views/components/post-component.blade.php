<div class="container">
    {!! !$post->OP ? "<div class='sidearrows'>>></div>" : '' !!}
    <div class="post {{ $post->id == $post->thread_id ? 'main' : 'reply' }}" id="p{{ $post->id }}">
        <div class="title-container">
            <span class="title">{{ $post->title }}</span>
            <span class="author">{{ $post->author }}</span>
            <span class="created-at">{{ $post->created_at }}</span>
            <span>
                <a href="#" class="link" title="Link to this post">No.</a>
                <a href="#" class="id" title="Reply to this post">{{ $post->id }}</a>
            </span>
            {{-- Need to fix later, linkin to thread  --}}
            {{-- <a href="{{ route('thread', ['boardName' => $post->thread_id, 'threadId' => $post->thread_id, 'threadTitle' => $post->thread_id])}}">Route</a> --}}
            <i class="fa-solid fa-caret-right"></i>
        </div>
        <div class="content-container">
            <p class="content">{!! $post->content !!}</p>
        </div>
    </div>
</div>
