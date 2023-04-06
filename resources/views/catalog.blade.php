@extends('layout.app')

@section('content')
    <div class="main d-flex f-column">
        <x-topbar-component :boardName="$board->name" :showReturn=true :showArchive=true :showBottom=true :showRefresh=true />
        <div class="thread d-flex">
            @foreach ($OPs as $OP)
                <div class="thumb-container">
                    <a
                        href="{{ route('thread', [
                            'boardName' => $OP->getBoardId(),
                            'threadId' => $OP->getThreadId(),
                            'threadTitle' => $OP->getThread()->title,
                        ]) }}">
                        @if ($OP->getImage())
                            <img src="{{ Storage::url($OP->getImage()->image_small) }}" alt="test image" class="thumbnail">
                        @else
                            <img src="{{ Vite::asset('resources/images/test.jpg') }}" alt="test image" class="thumbnail">
                        @endif
                    </a>
                    <p>R : <span><strong>{{ count($OP->getThread()->getPosts()) }}</strong></span></p>
                    <p>{!! $OP->getThread()->title !!}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('script')
@endpush()
