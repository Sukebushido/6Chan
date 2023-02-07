@extends("layout.app")

@section("content")
    <div class="test">
        <p>I'm a blue board</p>
        @foreach ($posts as $post)
        {{-- {{dd($post->thread_id)}} --}}
            <div class="container {{$post->id == $post->thread_id ? "main" : "reply"}}">
                <p>id : {{$post->id}}</p>
                <p>title : {{$post->title}}</p>
                <p>author : {{$post->author}}</p>
                <p>créé le : {{$post->created_at}}</p>
                <p>OP : {{$post->OP}}</p>
                <p>Contenu : {{$post->content}}</p>
            </div>
        @endforeach
    </div>
@endsection