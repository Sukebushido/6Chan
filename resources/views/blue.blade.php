@extends('layout.app')

@section('content')
    <div class="test main">
        <p>I'm a blue board</p>
        @foreach ($posts as $post)
            {{-- {{dd($post->thread_id)}} --}}
            <div class="container">
                {!! !$post->OP ? "<div class='siderarrows'>>></div>" : "" !!}
                <div class="post {{ $post->id == $post->thread_id ? 'main' : 'reply' }}">
                    <div class="title-container">
                        <span class="title">{{ $post->title }}</span>
                        <span class="author">{{ $post->author }}</span>
                        <span class="created-at">{{ $post->created_at }}</span>
                        <span class="id">No.{{ $post->id }}</span>
                    </div>
                    <div class="content-container">
                        <p class="content">{{ $post->content }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
