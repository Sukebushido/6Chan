<template id="quickReplyTemplate" hidden style="display: none">
    <div class="container" id="quickReplyBox">
        <form method="post" action="{{ route('post', ['boardName' => $boardName]) }}" id="reply_form" class="reply-box"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="quick-threadId" id="quick-inputThreadId" value="">
            <div class="header">
                <p class="title">Reply to Thread No.<span id="template_thread_id"></span></p>
                <i class="fa-solid fa-xmark" id="closeCross"></i>
            </div>
            <input type="text" name="quick-name" id="quick-name" placeholder="Name" autocomplete="off">
            <input type="text" name="quick-options" id="quick-options" placeholder="Options" autocomplete="off">
            <textarea name="quick-comment" id="quick-comment" placeholder="Comment" autocomplete="off"></textarea>
            <div class="captcha-div">
                <div class="top">
                    <button type="button">Get captcha</button>
                    <input type="text" name="quick-captcha" id="quick-captcha">
                    <button type="button">?</button>
                </div>
                <div class="captcha-img">
                    {{-- captcha here --}}
                </div>
            </div>
            <div class="footer">
                <input type="file" name="quick-image" id="quick-image">
                <button type="button" id="quick-submitButton">Post</button>
            </div>
            <div class="errors">
                <p id="errorMessage" class="error hidden"></p>
            </div>
        </form>
    </div>
</template>

@pushOnce('scripts')
    <script>
        window.addEventListener("load", function() {
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
                    let threadId = link.parentElement.parentElement.parentElement.parentElement
                        .parentElement
                        .id.substring(1) || link.parentElement.parentElement.parentElement
                        .parentElement
                        .id.substring(1);
                    if (!document.body.contains(document.querySelector('#quickReplyBox'))) {
                        const quickReply = template.content.firstElementChild.cloneNode(true);
                        const quickThreadInput = quickReply.querySelector('#quick-inputThreadId')
                        const quickNameInput = quickReply.querySelector('#quick-name');
                        const quickOptionsInput = quickReply.querySelector('#quick-options');
                        const quickCommentInput = quickReply.querySelector('#quick-comment');
                        const quickCaptchaInput = quickReply.querySelector('#quick-captcha');
                        const quickImageInput = quickReply.querySelector('#quick-image');
                        const closeCross = quickReply.querySelector('#quick-closeCross')
                        const quickErrorMessage = quickReply.querySelector('#quick-errorMessage');
                        quickReply.querySelector('#template_thread_id').innerHTML = threadId
                        quickThreadInput.value = threadId
                        quickReply.querySelector('#comment').value = ">>" + link.innerHTML + "\n"

                        quickReply.querySelector('#closeCross').addEventListener('click', () => {
                            finalPosX = quickReply.style.left;
                            finalPosY = quickReply.style.top;
                            quickReply.remove();
                        })
                        quickReply.querySelector('#submitButton').addEventListener('click', (e) => {
                            e.preventDefault();
                            console.log(quickImageInput.files[0]);
                            axios.post(
                                    "{{ route('post', ['boardName' => $boardName]) }}", {
                                        "threadId": quickThreadInput.value,
                                        "name": quickNameInput.value,
                                        "options": quickOptionsInput.value,
                                        "comment": quickCommentInput.value,
                                        "captcha": quickCaptchaInput.value,
                                        "image": quickImageInput.files[0] ?? ""
                                    }, {
                                        headers: {
                                            "Content-type": "multipart/form-data"
                                        }
                                    })

                                .then(function(response) {
                                    /* Refresh page */
                                    quickErrorMessage.innerText = "";
                                    quickErrorMessage.classList.add('hidden')
                                    // window.location.reload();
                                }).catch(error => {
                                    quickErrorMessage.innerText = "";
                                    if (error.response.data.message.includes(
                                            'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails'
                                        )) {
                                        quickErrorMessage.innerText =
                                            "Problem in writing in database, maybe your quotations are messed up";
                                        quickErrorMessage.classList.remove('hidden')
                                    } else {
                                        let errors = error.response.data.errors;
                                        if (errors == null) {
                                            quickErrorMessage.innerText = error.message
                                        } else {
                                            let errors2 = Object.values(errors);
                                            for (let error of Object.values(errors)) {
                                                quickErrorMessage.innerText +=
                                                    `${error[0]}\n`;
                                            }
                                            quickErrorMessage.classList.remove('hidden')
                                        }
                                    }
                                })
                        })
                        if (finalPosX !== 0 && finalPosY !== 0) {
                            quickReply.style.top = finalPosY;
                            quickReply.style.left = finalPosX;
                        } else {
                            quickReply.style.top = "150px";
                            quickReply.style.left = "300px";
                        }
                        document.querySelector('.placeholder').appendChild(quickReply);
                        quickReply.querySelector('#comment').focus();
                        dragElement(quickReply);
                    } else {
                        const quickReply = document.getElementById('quickReplyBox')
                        let comment = quickReply.querySelector('#comment');
                        let prevCommentValue = comment.value
                        let prevThread = quickReply.querySelector('#template_thread_id').innerHTML
                        let quickThreadInput = quickReply.querySelector('#inputThreadId')

                        if (prevThread != threadId) {
                            quickThreadInput.value = threadId
                            quickReply.querySelector('#template_thread_id').innerHTML = threadId
                            comment.value = ">>" + link.innerHTML + "\n";
                            quickReply.querySelector('#comment').focus();
                        } else {
                            comment.value = prevCommentValue + ">>" + link.innerHTML + "\n"
                            quickReply.querySelector('#comment').focus();
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
        })
    </script>
@endPushOnce
