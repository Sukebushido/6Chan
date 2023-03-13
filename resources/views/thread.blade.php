@extends('layout.app')

@section('content')
    <div class="test main">
        <div class="top_bar">
            {{-- {{ dd($thread->getBoard()) }} --}}
            <span>[<a href="{{ route('board', ['boardName' => $thread->getBoardName()]) }}">Return</a>]</span>
            <span>[<a href="{{ route('catalog', ['boardName' => $thread->getBoardName()]) }}">Catalog</a>]</span>
            <span>[<a href="">Bottom</a>]</span>
            <span>[<a href="">Update</a>]</span>
        </div>
        @foreach ($thread->getPosts() as $post)
            <x-post-component :post="$post" />
        @endforeach
        <button id="testButton">Clique</button>
        <div class="placeholder">
        </div>
        <x-reply-component :boardName="$thread->getBoardName()" />
    </div>
    <div class="test2">
        <p id="pos1">#</p>
        <p id="pos2">#</p>
        <p id="pos3">#</p>
        <p id="pos4">#</p>
        <p id="clientX">#</p>
        <p id="clientY">#</p>
    </div>
@endsection
