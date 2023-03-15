@extends('layout.app')

@section('content')
    <div class="main d-flex">
        @foreach ($OPs as $OP)
            {{-- {{ $OP->getBoard() }} --}}
            <div class="thumb-container">
                <a
                    href="{{ route('thread', [
                        'boardName' => $OP->getBoardId(),
                        'threadId' => $OP->getThreadId(),
                        'threadTitle' => $OP->getThread()->title,
                    ]) }}">
                    <img src="{{ Vite::asset('resources/images/test.jpg') }}" alt="test image" class="thumbnail">
                </a>
                <p>R : <span><strong>{{ count($OP->getThread()->getPosts()) }}</strong></span></p>
                <p>{!! $OP->title ? '<span><strong>' . $OP->title . '</strong>: </span>' : '' !!}{{ $OP->content }}</p>
            </div>
        @endforeach
    </div>
@endsection

@push('script')
@endpush()
