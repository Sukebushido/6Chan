<div class="post container" id="p{{ $post->id }}">
    {!! !$post->OP ? "<div class='sidearrows'>>></div>" : '' !!}
    <div class="{{ $post->id == $post->thread_id ? 'main' : 'reply' }}">
        <div class="title-container">
            <span class="title">{{ $post->title }}</span>
            <span class="author">{{ $post->author }}</span>
            <span class="created-at">{{ $post->created_at }}</span>
            <span>
                <a href="#" class="link" title="Link to this post" wire:click="$emitSelf('show')">No.</a>
                <a href="#" class="id" title="Reply to this post">{{ $post->id }}</a>
            </span>
            {!! $post->OP && Request::is($post->getBoardName())
                ? '[<a href="' .
                    route('thread', [
                        'boardName' => $post->getBoardName(),
                        'threadId' => $post->getThreadId(),
                        'threadTitle' => $post->getThreadTitle(),
                    ]) .
                    '">Reply</a>]'
                : '' !!}
            <i class="fa-solid fa-caret-right"></i>
        </div>
        <div class="content-container">
            <p class="content">{!! $post->content !!}</p>
        </div>
        @if ($show)
            <livewire:reply-component :boardName="$post->getBoardName()" :wire:key="'post-'.$post->id">
        @endif
    </div>
</div>

{{-- @pushOnce('scripts')
<script defer>
    let links = document.querySelectorAll('.id')
    console.log(links);
    links.forEach(link => {
        link.addEventListener('click', () => {
            Livewire.emit('postAdded')
        })
    })
</script>

@endPushOnce --}}
