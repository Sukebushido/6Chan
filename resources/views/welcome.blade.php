@extends("layout.app")

@section("content")
    <div class="test">
        <p>Hello, landing page</p>
        <a href="{{route('board', ['boardName' => 'blue'])}}">Blue board</a>
        <a href="{{route('board', ['boardName' => 'red'])}}">Red board</a>
    </div>
@endsection