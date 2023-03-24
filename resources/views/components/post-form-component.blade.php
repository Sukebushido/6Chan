<div class="d-flex f-column f-center">
    <p>[{{ $thread ? 'Post a Reply' : 'Create new Thread' }}]</p>
    <form action="{{ $thread ? route('post', ['boardName' => $thread->getBoardName()]) : 'Create new Thread' }}"
        method="POST" id="post-form">
        @csrf
        <table>
            <tbody>
                <tr data-type="name">
                    <td class="label">
                        Name
                    </td>
                    <td>
                        <input type="text" name="name" id="name" tabindex="3" placeholder="Anonymous">
                    </td>
                </tr>
                <tr data-type="options">
                    <td class="label">
                        Options
                    </td>
                    <td>
                        <input type="text" name="options" id="options"tabindex="3">
                    </td>
                </tr>
                <tr data-type="subject">
                    <td class="label">
                        Subject
                    </td>
                    <td>
                        <input type="text" name="subject" id="subject" tabindex="3">
                        <input type="submit" value="Post" tabindex="3" id="submit-btn">
                    </td>
                </tr>
                <tr data-type="comment">
                    <td class="label">
                        Comment
                    </td>
                    <td>
                        <textarea name="comment" cols="48" rows="4" wrap="soft" tabindex="4" id="comment"></textarea>
                    </td>
                </tr>
                <tr data-type="verification">
                    <td class="label">
                        Verification
                    </td>
                    <td>
                        <input type="text" name="verification" id="verification" placeholder="Coming Soon" disabled>
                    </td>
                </tr>
                <tr data-type="file">
                    <td class="label">
                        File
                    </td>
                    <td>
                        <input type="file" name="image" id="image">
                    </td>
                </tr>
                <tr data-type="errors" id="errors-row" class="hidden">
                    <td id="errors" colspan="2" class="error">Errors</td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="threadId" id="inputThreadId" value="">
    </form>
</div>

@pushOnce('scripts')
    <script defer>
        window.addEventListener("load", function() {
            const form = document.getElementById('post-form')
            const form_button = document.getElementById('submit-btn');
            const error_data = document.getElementById('errors');
            const error_row = document.getElementById('errors-row');

            const threadIdInput = form.querySelector('#inputThreadId')
            const nameInput = form.querySelector('#name');
            const optionsInput = form.querySelector('#options');
            const commentInput = form.querySelector('#comment');
            const captchaInput = form.querySelector('#captcha');
            const imageInput = form.querySelector('#image');

            form_button.addEventListener('click', function(e) {
                e.preventDefault();
                axios.post(
                        "{{ route('post', ['boardName' => $thread->getBoardName()]) }}", {
                            "threadId": {!! $thread->id !!},
                            "name": nameInput.value,
                            "options": optionsInput.value,
                            "comment": commentInput.value,
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
                        error_data.innerText = "";
                        if (error.response.data.message.includes(
                                'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails'
                            )) {
                                error_data.innerText =
                                "Problem in writing in database, maybe your quotations are messed up";
                                error_row.classList.remove('hidden')
                        } else {
                            let errors = error.response.data.errors;
                            if (errors == null) {
                                error_data.innerText = error.message
                            } else {
                                let errors2 = Object.values(errors);
                                for (let error of Object.values(errors)) {
                                    error_data.innerText += `${error[0]}\n`;
                                }
                                error_row.classList.remove('hidden')
                            }
                        }
                    })
            })
        })
    </script>
@endPushOnce()
