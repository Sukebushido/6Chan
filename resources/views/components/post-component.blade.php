<div class="post container" id="p{{ $post->id }}">

    {!! !$post->OP ? "<div class='sidearrows'>>></div>" : '' !!}
    <div class="{{ $post->OP ? 'main' : 'reply' }} inner-post">
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
                @foreach ($post->trueChildren as $child)
                    <span class="backlink">>>{{ $child->id ?? '' }}</span>
                @endforeach
            </span>
        </div>
        @if ($post->image)
            <div class="img-metadata-container">
                @php
                    [$width, $height] = getimagesize(Storage::disk('public')->path($post->image));
                @endphp
                <p>File :
                    <a href={{ Storage::url($post->image) }} target="_blank" rel="noopener noreferrer">
                        {{ basename(Storage::disk('public')->url($post->image)) }} </a>(<span
                        class="space">{{ round(Storage::disk('public')->size($post->image) / 1000) }} KB</span>,
                    <span class="size">{{ $width }}x{{ $height }}</span>)
                </p>
            </div>
            <div class="img-container">
                <img src="{{ Storage::url($post->image) }}" alt="image">
            </div>
        @endif
        <div class="content-container">
            <p class="post-content">{!! nl2br($post->content) !!}</p>
        </div>
        <div class="test">
        </div>
    </div>

    <template id="cross-template">
        <div class="reply">
            <div class="title-container">
                <span class="title"></span>
                <span class="author"></span>
                <span class="created-at"></span>
                <span>
                    <a href="#" class="link" title="Link to this post">No.</a>
                    <a href="#" class="id" title="Reply to this post"></a>
                </span>
                <i class="fa-solid fa-caret-right"></i>
            </div>
            <div class="content-container">
                <p class="post-content"></p>
            </div>
            <div class="test">
            </div>
        </div>
    </template>
</div>
@pushOnce('scripts')
    <script>
        window.onload = () => {
            const crossTemplate = document.getElementById('cross-template');
            let allOfTemplates = document.querySelectorAll('#cross-template');
            allOfTemplates.forEach(template => {
                template.remove()
            });

            // Links logic
            let delay;
            let links = document.querySelectorAll(".backlink, .quotelink");
            let hoveredLink = "";

            // Axios stuff
            let fetchedData;
            let currentPostsInFetchedThread = [];
            const trimRegex = /\d+/g

            let options = {
                root: null, // for checking relative to viewport
                rootmargin: "0px",
                threshold: 1.0 // callback called when 100% of object is on screen
            };

            let callback = (entries, observer) => {
                entries.forEach((entry) => {
                    let target = entry.target
                    if (entry.isIntersecting) {
                        target.classList.add('highlight')
                    } else if (!document.getElementById('quote-preview')) {
                        let coordinates = {
                            x: hoveredLink.offsetLeft,
                            y: hoveredLink.offsetTop,
                        }
                        let clone = target.cloneNode(true);
                        clone.id = "quote";
                        let quotePreview = document.createElement("div");
                        quotePreview.id = "quote-preview";
                        quotePreview.appendChild(clone);
                        document.querySelector("body").appendChild(quotePreview);
                        quotePreview.style.left =
                            `${coordinates.x + hoveredLink.offsetWidth + 5}px`
                        quotePreview.style.top =
                            `${coordinates.y - (quotePreview.offsetHeight / 2 - hoveredLink.offsetHeight / 2)}px`
                    }
                });
            }

            let observer = new IntersectionObserver(callback, options);

            links.forEach(link => {
                let rawChildId = link.innerText;
                let childId = link.innerText.match(trimRegex)[0];
                let childElem;

                link.addEventListener('pointerenter', (e) => {
                    if (rawChildId.includes("→")) {
                        if (!fetchedData || fetchedData && (!currentPostsInFetchedThread.includes(
                                parseInt(childId)))) {
                            axios.get(`{!! '/api/' . $post->getBoardName() . '/${childId}' !!}`)
                                .then(res => {
                                    fetchedData = (res.data);
                                    currentPostsInFetchedThread = fetchedData.map(entry => entry.id)
                                })
                                .then(res => {
                                    fillAndAppendTemplate(fetchedData, childId, e.target)
                                })
                                .catch(err => {
                                    console.log(err);
                                })
                        } else {
                            fillAndAppendTemplate(fetchedData, childId, e.target)
                        }
                    } else {
                        childElem = document.getElementById(`p${childId}`).querySelector('.inner-post')
                        hoveredLink = e.target
                        observer.observe(childElem);
                    }
                })

                function fillAndAppendTemplate(data, childID, hoveredLink) {
                    let clone = crossTemplate.content.firstElementChild.cloneNode(true);
                    let quote = data.filter(entry => entry.id == childID)[0];
                    clone.querySelector('.id').innerText = childID
                    clone.querySelector('.title').innerText = quote.title
                    clone.querySelector('.author').innerText = quote.author
                    // Necessary for formatting
                    clone.querySelector('.created-at').innerText = quote.created_at.replace("T", " ").substring(
                        0, quote.created_at.length - 8)
                    clone.querySelector('.post-content').innerHTML = quote.content

                    let coordinates = {
                        x: hoveredLink.offsetLeft,
                        y: hoveredLink.offsetTop,
                    }

                    let quotePreview = document.createElement("div");
                    quotePreview.id = "quote-preview";
                    quotePreview.appendChild(clone);
                    document.querySelector("body").appendChild(quotePreview);

                    quotePreview.style.left =
                        `${coordinates.x + hoveredLink.offsetWidth + 5}px`
                    quotePreview.style.top =
                        `${coordinates.y - (quotePreview.offsetHeight / 2 - hoveredLink.offsetHeight / 2)}px`
                }

                link.addEventListener('pointerleave', () => {
                    if (document.getElementById("quote-preview")) {
                        document.getElementById("quote-preview").remove();
                    }
                    observer.disconnect()
                    hoveredLink = ""
                    highlighted = document.querySelectorAll('.highlight');
                    highlighted.forEach(element => {
                        element.classList.remove('highlight')
                    })
                })
            });

            let pointerLeaveEvent = new Event('pointerleave')
            document.onscroll = () => {
                clearTimeout(delay)
                delay = setTimeout(() => {
                    links.forEach(link => {
                        link.dispatchEvent(pointerLeaveEvent)
                    })
                }, 500);
            };
        }
    </script>
@endPushOnce()
