<div>
    <template id="quickReplyTemplate" hidden>
        <div class="container" id="quickReplyBox">
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

@pushOnce('scripts')
    <script>
        const replyLinks = document.querySelectorAll('.id')
        const template = document.getElementById('quickReplyTemplate')
        replyLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (!document.body.contains(document.querySelector('#quickReplyBox'))) {
                    const quickReply = template.content.firstElementChild.cloneNode(true);
                    const nameInput = quickReply.querySelector('#name');
                    const optionsInput = quickReply.querySelector('#options');
                    const commentInput = quickReply.querySelector('#comment');
                    const captchaInput = quickReply.querySelector('#captcha');
                    const imageInput = quickReply.querySelector('#file');
                    const closeCross = quickReply.querySelector('#closeCross')
                    const errorMessage = quickReply.querySelector('#errorMessage');
                    let thread = link.parentElement.parentElement.parentElement.parentElement.parentElement
                        .id.substring(1);

                    quickReply.querySelector('#template_thread_id').innerHTML = thread
                    quickReply.querySelector('#comment').value = ">>" + link.innerHTML
                    quickReply.querySelector('#closeCross').addEventListener('click', () => {
                        quickReply.remove();
                    })
                    quickReply.querySelector('#submitButton').addEventListener('click', (e) => {
                        e.preventDefault();
                        axios.post(
                                "{{ route('post', ['boardName' => $boardName]) }}", {
                                    "name": nameInput.value,
                                    "options": optionsInput.value,
                                    "comment": commentInput.value,
                                    "captcha": captchaInput.value,
                                    "file": imageInput.value
                                })
                            .then(function(response) {
                                console.log(response, "kek");
                            }).catch(error => {
                                errorMessage.innerText = error.response.data.errors.comment[0]
                                errorMessage.classList.remove('hidden')
                            })
                    })

                    document.querySelector('.placeholder').appendChild(quickReply)
                } else {
                    const quickReply = document.getElementById('quickReplyBox')
                    let comment = quickReply.querySelector('#comment');
                    let prevCommentValue = comment.value
                    comment.value = prevCommentValue + "\n" + ">>" + link.innerHTML
                }
            })
        });
    </script>
@endPushOnce
