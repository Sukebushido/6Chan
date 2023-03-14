@extends('layout.app')

@section('content')
    <div class="main">
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
@endsection
