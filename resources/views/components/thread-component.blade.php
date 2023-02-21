<div class="test main">
    <p>kek</p>
    {{-- <p>I'm a blue board</p>
    @foreach ($posts as $post)
        {{dd($post->thread_id)}}
        <div class="container">
            {!! !$post->OP ? "<div class='sidearrows'>>></div>" : '' !!}
            <div class="post {{ $post->id == $post->thread_id ? 'main' : 'reply' }}" id="p{{ $post->id }}">
                <div class="title-container">
                    <span class="title">{{ $post->title }}</span>
                    <span class="author">{{ $post->author }}</span>
                    <span class="created-at">{{ $post->created_at }}</span>
                    <span class="id">No.{{ $post->id }}</span>
                    <i class="fa-solid fa-caret-right"></i>
                </div>
                <div class="content-container">
                    <p class="content">{!! $post->content !!}</p>
                </div>
            </div>
        </div>
    @endforeach
    <x-reply-box :thread="$thread_id" />
    <button id="testButton">Clique</button> --}}
</div>
