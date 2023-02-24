@extends('layout.app')

@section('content')
    @foreach ($OPs as $OP)
    {{-- {{ $OP->getBoard() }} --}}
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
