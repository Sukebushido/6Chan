@extends('layout.app')

@section('content')
    <div class="test main">
        @foreach ($thread->getPosts() as $post)
            <x-post-component :post="$post" />
        @endforeach
        <button id="testButton">Clique</button>
    </div>
@endsection

@push('script')
@endpush()
