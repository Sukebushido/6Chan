@extends('layout.app')

@section('content')
    <div class="main d-flex f-column">
        <div class="top-bar d-flex f-column">
            <div class="thread-border"></div>
            <div class="content">
                <span>[<a href="{{ route('catalog', ['boardName' => $boardName]) }}">Catalog</a>]</span>
            </div>
            <div class="thread-border"></div>
        </div>
        @foreach ($threads as $thread)
            <div class="thread" id="t{{ $thread->id }}">
                @foreach ($thread->getPosts() as $post)
                    <x-post-component :post="$post" />
                @endforeach 
            </div>
            <div class="thread-border"></div>
        @endforeach
        <button id="testButton">Clique</button>
        <div class="placeholder"></div>
        <x-reply-component :boardName="$boardName" />
    </div>
@endsection
