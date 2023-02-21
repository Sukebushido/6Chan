@extends('layout.app')

@section('content')
    <div class="test main">
        <p>I'm a blue board</p>
        @foreach ($threads as $thread)
            @foreach ($thread->getPosts() as $post)
                <x-post-component :post="$post" />
            @endforeach <br>
        @endforeach
        <button id="testButton">Clique</button>
    </div>
@endsection

@push('script')
@endpush()
