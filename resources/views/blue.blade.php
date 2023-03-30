@extends('layout.app')

@section('content')
    <div class="main d-flex f-column">
        <x-post-form-component :isThread="false" :threadId="null" :boardName="$boardName" />
        <x-topbar-component :boardName="$boardName" :showCatalog=true :showArchive=true/>
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
