@extends('layout.app')

@section('content')
    @foreach ($OPs as $OP)
    {{-- {{ $OP->getBoard() }} --}}
    <p>R : <span><strong>{{ count($OP->getThread()->getPosts()) }}</strong></span></p>
        <p>
            <a href="{{ route('thread', 
                ['boardName' => $OP->getBoardId(), 
                'threadId' => $OP->getThreadId(), 
                'threadTitle' => $OP->getThread()->title]) }}" >
                {{ $OP->title ?? $OP->content }}
            </a>
        </p>
    @endforeach
@endsection

@push('script')
@endpush()
