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
            <span class="backlink-container">
                @foreach ($post->children as $child)
                    <span class="backlink">>>{{ $child->id ?? '' }}</span>
                @endforeach
            </span>
        </div>
        <div class="content-container">
            <p class="content">{!! $post->content !!}</p>
        </div>
        <div class="test">
        </div>
    </div>
</div>

@pushOnce('scripts')
    <script>
        let backlinks = document.querySelectorAll(".backlink");

        backlinks.forEach(backlink => {
            backlink.addEventListener('mouseenter', () => {
                let childId = backlink.innerText.substring(2)
                let childElem = document.getElementById(`p${childId}`).querySelector('.reply')
                let coordinates = {
                    x: backlink.offsetLeft,
                    y: backlink.offsetTop,
                }
                let clone = childElem.cloneNode(true);
                clone.id = "quote";
                let quotePreview = document.createElement("div");
                quotePreview.id = "quote-preview";
                quotePreview.appendChild(clone);
                document.querySelector("body").appendChild(quotePreview);
                quotePreview.style.left = `${coordinates.x + backlink.offsetWidth + 5}px`
                quotePreview.style.top =
                    `${coordinates.y - (quotePreview.offsetHeight / 2 - backlink.offsetHeight / 2)}px`
            })
            backlink.addEventListener('mouseleave', () => {
                if (document.getElementById("quote-preview")) {
                    document.getElementById("quote-preview").remove();
                }
            })
        });
    </script>
@endPushOnce()
