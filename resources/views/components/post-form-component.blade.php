<div class="d-flex f-column f-center">
    <p>[{{ $isThread ? 'Post a Reply' : 'Create new Thread' }}]</p>
    <form
        action="{{ $isThread ? route('post', ['boardName' => $boardName]) : route('newThread', ['boardName' => $boardName]) }}"
        method="POST" id="post-form">
        @csrf

        <div class="top-form-container d-flex">
            <div class="top-fields-container d-flex f-column">
                <div data-type="name" class="field-container">
                    <label for="name" class="label">Name</label>
                    <input type="text" name="name" id="name" tabindex="3" placeholder="Anonymous" autocomplete="off">
                </div>
                <div data-type="options" class="field-container">
                    <label for="options" class="label">Options</label>
                    <input type="text" name="options" id="options"tabindex="3" autocomplete="off">
                </div>
                @if (!$thread)
                    <div data-type="subject" class="field-container">
                        <label for="subject" class="label">Subject</label>
                        <input type="text" name="subject" id="subject" tabindex="3" autocomplete="off">
                    </div>
                @endif
            </div>
            <div class="post-button">
                <input type="submit" value="Post" tabindex="3" id="submit-btn">
            </div>
        </div>
        <div data-type="comment" class="field-container">
            <label for="comment" class="label">Comment</label>
            <textarea name="comment" cols="48" rows="4" wrap="soft" tabindex="4" id="comment" autocomplete="off"></textarea>

        </div>
        <div data-type="verification" class="field-container">
            <label for="verification" class="label">Verification</label>
            <input type="text" name="verification" id="verification" placeholder="Coming Soon" disabled>
        </div>
        <div data-type="file" class="field-container">
            <label for="image" class="label">Image</label>
            <input type="file" name="image" id="image">
        </div>
        <div data-type="errors" id="errors-row" class="hidden">
            <div id="errors" colspan="2" class="error">Errors</div>
        </div>
        @if (!$isThread)
            <input type="hidden" name="boardName" id="boardName" value={{ $boardName }}>
        @endif
    </form>
</div>

@pushOnce('scripts')
    <script defer>
        window.addEventListener("load", function() {
            const form = document.getElementById('post-form')
            const form_button = document.getElementById('submit-btn');
            const error_data = document.getElementById('errors');
            const error_row = document.getElementById('errors-row');

            const boardInput = form.querySelector('#boardName')
            const nameInput = form.querySelector('#name');
            const optionsInput = form.querySelector('#options');
            const commentInput = form.querySelector('#comment');
            const captchaInput = form.querySelector('#captcha');
            const imageInput = form.querySelector('#image');

            @if (!$thread)
                const subjectInput = form.querySelector('#subject');
            @endif

            form_button.addEventListener('click', function(e) {
                e.preventDefault();
                axios.post(
                        "{{ $isThread ? route('reply', ['boardName' => $boardName]) : route('newThread', ['boardName' => $boardName]) }}", {
                            "threadId": {{ $isThread ? $thread->id : 'null' }},
                            "boardName": boardInput ? boardInput.value : "",
                            "name": nameInput.value,
                            "options": optionsInput.value,
                            "comment": commentInput.value,
                            @if (!$thread)
                                "subject": subjectInput.value ?? "",
                            @endif
                            "captcha": null,
                            "image": imageInput.files[0] ?? ""
                        }, {
                            headers: {
                                "Content-type": "multipart/form-data"
                            }
                        })

                    .then(function(response) {
                        /* Refresh page */
                        error_data.innerText = "";
                        error_row.classList.add('hidden')
                        // window.location.reload();
                    }).catch(error => {
                        error_data.innerHTML = "";
                        if (error.response.data.message.includes(
                                'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails'
                            )) {
                            error_data.innerHTML =
                                "<span>Problem in writing in database, maybe your quotations are messed up</span>";
                            error_row.classList.remove('hidden')
                        } else {
                            let errors = error.response.data.errors;
                            if (errors == null) {
                                error_data.innerText = error.message
                            } else {
                                let errors2 = Object.values(errors);
                                for (let error of Object.values(errors)) {
                                    error_data.innerHTML += `<span>${error[0]}</span></br>`;
                                }
                                error_row.classList.remove('hidden')
                            }
                        }
                    })
            })
        })
    </script>
@endPushOnce()
