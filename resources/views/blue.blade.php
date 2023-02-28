@extends('layout.app')

@section('content')
    <div class="test main">
        <p>I'm a blue board</p>
        @foreach ($threads as $thread)
            <div class="thread" id="t{{ $thread->id }}">
                @foreach ($thread->getPosts() as $post)
                    <x-post-component :post="$post" />
                @endforeach <br>
            </div>
        @endforeach
        <button id="testButton">Clique</button>
        <div class="placeholder"></div>
        <x-reply-component :boardName="$boardName" />
    </div>
@endsection
