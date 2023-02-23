@extends('layout.app')

@section('content')
    <div class="test main">
        <div class="top_bar">
            {{-- {{ dd($thread->getBoard()) }} --}}
            <span>[<a href="{{ route("board", ["boardName" => $thread->getBoard()->name]) }}">Return</a>]</span>
            <span>[<a href="">Catalog</a>]</span>
            <span>[<a href="">Bottom</a>]</span>
            <span>[<a href="">Update</a>]</span>
        </div>
        @foreach ($thread->getPosts() as $post)
            <x-post-component :post="$post" />
        @endforeach
        <button id="testButton">Clique</button>
    </div>
@endsection

@push('script')
@endpush()
