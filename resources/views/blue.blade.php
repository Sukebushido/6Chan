@extends('layout.app')

@section('content')
    <div class="test main">
        <p>I'm a blue board</p>
        @foreach ($threads as $thread)
            <div class="thread" id="t{{$thread -> id}}">
                @foreach ($thread->getPosts() as $post)
                    <x-post-component :post="$post" />
                @endforeach <br>
            </div>
        @endforeach
        <button id="testButton">Clique</button>
        <div class="placeholder"></div>

        {{-- Template --}}
        <template id="quickReplyTemplate" hidden>
            <div class="container" id="replyBox">
                <form method="post" action="{{ route('post', ['boardName' => $boardName]) }}" id="reply_form"
                    class="reply-box">
                    @csrf
                    <div class="header">
                        <p class="title">Reply to Thread No.<span id="template_thread_id"></span></p>
                        <i class="fa-solid fa-xmark" id="closeCross"></i>
                    </div>
                    <input type="text" name="name" id="name" placeholder="Name" autocomplete="off">
                    <input type="text" name="options" id="options" placeholder="Options" autocomplete="off">
                    <textarea name="comment" id="comment" placeholder="Comment" autocomplete="off"></textarea>
                    <div class="captcha-div">
                        <div class="top">
                            <button type="button">Get captcha</button>
                            <input type="text" name="captcha" id="captcha">
                            <button type="button">?</button>
                        </div>
                        <div class="captcha-img">
                            {{-- captcha here --}}
                        </div>
                    </div>
                    <div class="footer">
                        <input type="file" name="file" id="file">
                        <button type="submit" id="submitButton">Post</button>
                    </div>
                    <div class="errors">
                        <p id="errorMessage" class="error hidden"></p>
                    </div>
                </form>
            </div>
        </template>
    </div>
@endsection

@push('scripts')
    <script>
        const replyLinks = document.querySelectorAll('.id')
        const template = document.getElementById('quickReplyTemplate')
        replyLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (!document.body.contains(document.querySelector('#replyBox'))){
                    const quickReply = template.content.firstElementChild.cloneNode(true);
                    let thread = link.parentElement.parentElement.parentElement.parentElement.parentElement.id.substring(1);
    
                    quickReply.querySelector('#template_thread_id').innerHTML = thread
                    quickReply.querySelector('#comment').value = ">>" + link.innerHTML
    
                    document.querySelector('.placeholder').appendChild(quickReply)
                    document.getElementById('closeCross').addEventListener('click', () => {
                        quickReply.remove();
                    })                    
                } else {
                    const quickReply = document.getElementById('replyBox')
                    let comment = quickReply.querySelector('#comment');
                    let prevCommentValue = comment.value
                    comment.value = prevCommentValue + "\n" + ">>" + link.innerHTML
                }
            })
        });
    </script>
@endpush()
