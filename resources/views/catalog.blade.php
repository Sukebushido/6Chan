@extends('layout.app')

@section('content')
    @foreach ($OPs as $OP)
        <a href="{{ route("thread", ["boardName" => $OP->getThread()->getBoard()->id, "threadId" => $OP->getThread()->id, "threadTitle" => $OP->getThread()->title]) }}">{{ $OP->title ?? $OP->content}}</a>
    @endforeach
@endsection

@push('script')
    @endpush()