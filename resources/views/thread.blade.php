@extends('layout.app')

@section('content')
<div class="thread main d-flex f-column" id="t{{ $thread->id }}">
    <x-topbar-component :boardName="$thread->getBoardName()" :showReturn=true :showCatalog=true :showBottom=true :showUpdate=true />
        @foreach ($thread->getPosts() as $post)
            <x-post-component :post="$post" />
        @endforeach
        <button id="testButton">Clique</button>
        <div class="placeholder">
        </div>
        <x-reply-component :boardName="$thread->getBoardName()" />
    </div>
@endsection
