<template id="quickReplyTemplate" hidden style="display: none">
    <div class="container" id="quickReplyBox">
        <form method="post" action="{{ route('post', ['boardName' => $boardName]) }}" id="reply_form" class="reply-box">
            @csrf
            <input type="hidden" name="threadId" id="inputThreadId" value="">
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

@pushOnce('scripts')
    <script>
        const posElem1 = document.getElementById('pos1');
        const posElem2 = document.getElementById('pos2');
        const posElem3 = document.getElementById('pos3');
        const posElem4 = document.getElementById('pos4');
        const clientXElem = document.getElementById('clientX');
        const clientYElem = document.getElementById('clientY');
        const template = document.getElementById('quickReplyTemplate');
        let finalPosX = 0;
        let finalPosY = 0;
        template.remove();
        const replyLinks = document.querySelectorAll('.id')
        replyLinks.forEach(link => {
            link.addEventListener('click', () => {
                let threadId = link.parentElement.parentElement.parentElement.parentElement.parentElement
                    .id.substring(1) || link.parentElement.parentElement.parentElement.parentElement
                    .id.substring(1);
                if (!document.body.contains(document.querySelector('#quickReplyBox'))) {
                    const quickReply = template.content.firstElementChild.cloneNode(true);
                    const threadIdInput = quickReply.querySelector('#inputThreadId')
                    const nameInput = quickReply.querySelector('#name');
                    const optionsInput = quickReply.querySelector('#options');
                    const commentInput = quickReply.querySelector('#comment');
                    const captchaInput = quickReply.querySelector('#captcha');
                    const imageInput = quickReply.querySelector('#file');
                    const closeCross = quickReply.querySelector('#closeCross')
                    const errorMessage = quickReply.querySelector('#errorMessage');
                    quickReply.querySelector('#template_thread_id').innerHTML = threadId
                    threadIdInput.value = threadId
                    quickReply.querySelector('#comment').value = ">>" + link.innerHTML
                    quickReply.querySelector('#closeCross').addEventListener('click', () => {
                        finalPosX = quickReply.style.left;
                        finalPosY = quickReply.style.top;
                        quickReply.remove();
                    })
                    quickReply.querySelector('#submitButton').addEventListener('click', (e) => {
                        e.preventDefault();
                        axios.post(
                                "{{ route('post', ['boardName' => $boardName]) }}", {
                                    "threadId": threadIdInput.value,
                                    "name": nameInput.value,
                                    "options": optionsInput.value,
                                    "comment": commentInput.value,
                                    "captcha": captchaInput.value,
                                    "file": imageInput.value
                                })
                            .then(function(response) {
                                /* Refresh page */
                                errorMessage.innerText = "";
                                errorMessage.classList.add('hidden')
                                // window.location.reload();
                            }).catch(error => {
                                errorMessage.innerText = "";
                                let errors = error.response.data.errors;
                                if (errors == null) {
                                    errorMessage.innerText = error.message
                                } else {
                                    let errors2 = Object.values(errors);
                                    for (let error of Object.values(errors)) {
                                        errorMessage.innerText += `${error[0]}\n`;
                                    }
                                    errorMessage.classList.remove('hidden')
                                }

                            })
                    })
                    if (finalPosX !== 0 && finalPosY !== 0) {
                        quickReply.style.top = finalPosY;
                        quickReply.style.left = finalPosX;
                    } else {
                        quickReply.style.top = (link.offsetTop - 20) + "px";
                        quickReply.style.left = (link.offsetLeft + 20) + "px";
                    }
                    document.querySelector('.placeholder').appendChild(quickReply);
                    dragElement(quickReply);
                } else {
                    const quickReply = document.getElementById('quickReplyBox')
                    let comment = quickReply.querySelector('#comment');
                    let prevCommentValue = comment.value
                    let prevThread = quickReply.querySelector('#template_thread_id').innerHTML
                    let threadIdInput = quickReply.querySelector('#inputThreadId')

                    if (prevThread != threadId) {
                        threadIdInput.value = threadId
                        quickReply.querySelector('#template_thread_id').innerHTML = threadId
                        comment.value = ">>" + link.innerHTML;
                    } else {
                        comment.value = prevCommentValue + "\n" + ">>" + link.innerHTML
                    }
                }
            })
        });

        function dragElement(element) {
            let pos1 = 0,
                pos2 = 0,
                pos3 = 0,
                pos4 = 0;
            if (element.querySelector(".header")) {
                element.querySelector(".header").onmousedown = dragMouseDown
            }

            function dragMouseDown(e) {
                e.preventDefault();
                // get position at startup
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call function when cursor moves
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                // e = e || window.event;
                e.preventDefault();
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                element.style.top = (element.offsetTop - pos2) + "px";
                element.style.left = (element.offsetLeft - pos1) + "px";
            }

            function closeDragElement() {
                // stop moving when release button
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }
    </script>
@endPushOnce
