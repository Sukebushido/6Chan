<div class="post container" id="p{{ $post->id }}">
    {!! !$post->OP ? "<div class='sidearrows'>>></div>" : '' !!}
    <div class="{{ $post->OP ? 'main' : 'reply' }}">
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
        <div class="content-container">
            <p class="post-content">{!! nl2br($post->content) !!}</p>
        </div>
        <div class="test">
        </div>
    </div>
    <template id="cross-template">
        <div class="post container" id="p">
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
                    <span class="backlink-container">
                        @foreach ($post->trueChildren as $child)
                            <span class="backlink">>>{{ $child->id ?? '' }}</span>
                        @endforeach
                    </span>
                </div>
                <div class="content-container">
                    <p class="post-content"></p>
                </div>
                <div class="test">
                </div>
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

            // Backlinks logic
            let contents = document.querySelectorAll('.post-content');
            let quoteRegex = /(>{2}[0-9]+)\b/g;
            let quoteRegexWithArrow = /^>>\d+(\s→)?$/gm;

            // Links logic
            let delay;
            let links = document.querySelectorAll(".backlink, .quotelink");
            let hoveredLink = "";
            let fetchedData;
            let fetchedDataCurrentThread;

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
                let childId = link.innerText.substring(2)
                let childElem;

                link.addEventListener('pointerenter', (e) => {
                    if (childId.includes("→")) {
                        let clone = crossTemplate.content.firstElementChild.cloneNode(true);
                        let childIdTrimmed = childId.substring(0, childId.length - 2);
                        clone.querySelector('.id').innerText = childIdTrimmed
                        if (!fetchedData) {
                            axios.get(`{!! '/api/' . $post->getBoardName() . '/${childIdTrimmed}' !!}`)
                                .then(res => {
                                    fetchedData = (res.data);
                                    fetchedDataCurrentThread = fetchedData.filter(entry => entry.thread_id == 1)[0]
                                })
                                .then(res => {
                                    let quote = fetchedData.filter(entry => {
                                        console.log(entry.id);
                                        return entry.id == childIdTrimmed
                                    })[0];
                                    console.log({"quote" : quote});
                                    clone.querySelector('.title').innerText = quote.title
                                    clone.querySelector('.author').innerText = quote.author
                                    clone.querySelector('.created-at').innerText = quote.created_at
                                    clone.querySelector('.post-content').innerText = quote.content

                                    let quotePreview = document.createElement("div");
                                    quotePreview.id = "quote-preview";
                                    quotePreview.appendChild(clone);
                                    document.querySelector("body").appendChild(quotePreview);
                                })
                                .catch(err => {
                                    console.log(err);
                                })
                        } else {
                            let quote = fetchedData.filter(entry => entry.id == 1)[0];
                            clone.querySelector('.title').innerText = quote.title
                            clone.querySelector('.author').innerText = quote.author
                            clone.querySelector('.created-at').innerText = quote.created_at
                            clone.querySelector('.post-content').innerText = quote.content

                            let quotePreview = document.createElement("div");
                            quotePreview.id = "quote-preview";
                            quotePreview.appendChild(clone);
                            document.querySelector("body").appendChild(quotePreview);
                        }
                        // Check if threadID est différente, et si c'est le cas nécessité de renvoyer une requête

                    } else {
                        childElem = document.getElementById(`p${childId}`).querySelector('.reply')
                        hoveredLink = e.target
                        observer.observe(childElem);
                    }
                })

                link.addEventListener('pointerleave', () => {
                    console.log(childId);

                    if (childId.includes("→")) {
                        if (document.getElementById("quote-preview")) {
                            document.getElementById("quote-preview").remove();
                        }
                    } else {
                        observer.unobserve(childElem)
                        hoveredLink = ""
                        if (document.getElementById("quote-preview")) {
                            document.getElementById("quote-preview").remove();
                        }
                        highlighted = document.querySelectorAll('.highlight');
                        highlighted.forEach(element => {
                            element.classList.remove('highlight')
                        })
                        isMouseOverLink = false
                    }
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
