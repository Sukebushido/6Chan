<div class="post container" id="p{{ $post->id }}">
    {!! !$post->OP ? "<div class='sidearrows'>>></div>" : '' !!}
    <div class="{{ $post->id == $post->thread_id ? 'main' : 'reply' }}">
        <div class="title-container">
            <span class="title">{{ $post->title }}</span>
            <span class="author">{{ $post->author }}</span>
            <span class="created-at">{{ $post->created_at }}</span>
            <span>
                <a href="#" class="link" title="Link to this post">No.</a>
                <a href="#" class="id" title="Reply to this post">{{ $post->id }}</a>
            </span>
            {!! $post->OP && Request::is($post->getBoardName()) ? '[<a href="'.route('thread', ['boardName' => $post->getBoardName(), 'threadId' => $post->getThreadId(), 'threadTitle' => $post->getThreadTitle()]).'">Reply</a>]' : '' !!}
            <i class="fa-solid fa-caret-right"></i>
        </div>
        <div class="content-container">
            <p class="content">{!! $post->content !!}</p>
        </div>
    </div>
</div>
