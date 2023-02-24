@extends('layout.app')

@section('content')
    <div class="test main">
        <div class="top_bar">
            {{-- {{ dd($thread->getBoard()) }} --}}
            <span>[<a href="{{ route("board", ["boardName" => $thread->getBoard()->name]) }}">Return</a>]</span>
            <span>[<a href="{{route("catalog", ["boardName" => $thread->getBoard()->name])}}">Catalog</a>]</span>
            <span>[<a href="">Bottom</a>]</span>
            <span>[<a href="">Update</a>]</span>
        </div>
        @foreach ($thread->getPosts() as $post)
            <x-post-component :post="$post" />
        @endforeach
        <button id="testButton">Clique</button>
        <x-reply-box :thread="$thread"/>
    </div>
@endsection

@push('scripts')
    <script>
        const replyLinks = document.querySelectorAll('.id')
        const replyBox = document.getElementById('replyBox')
        replyLinks.forEach(link => {
            link.addEventListener('click', () => {
                replyBox.classList.remove('hidden')
                console.log("faggot");
            })
        });
    </script>
@endpush()
