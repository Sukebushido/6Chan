<div class="container">
    <form method="post" action="{{ route('post', ['boardName' => $thread->getBoard()->name]) }}" id="reply_form"
        class="reply-box">
        @csrf
        <div class="header">
            <p class="title">Reply to Thread No.{{ $thread->id }}</p>
            <i class="fa-solid fa-xmark"></i>
        </div>
        <input type="text" name="name" id="name" placeholder="Name" autocomplete="off">
        <input type="text" name="options" id="options" placeholder="Options" autocomplete="off">
        <textarea type="text" name="comment" id="comment" placeholder="Comment" autocomplete="off"></textarea>
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
    </form>
    <script>
        const submitButton = document.getElementById('submitButton');
        const nameInput = document.getElementById('name');
        const optionsInput = document.getElementById('options');
        const commentInput = document.getElementById('comment');
        const captchaInput = document.getElementById('captcha');
        const imageInput = document.getElementById('file');

        submitButton.addEventListener('click', (e) => {
            e.preventDefault();
            console.log("kek");
            axios.post("{{ route('post', ['boardName' => $thread->getBoardName()]) }}", {
                "name" : nameInput.value,
                "options" : optionsInput.value,
                "comment" : commentInput.value,
                "captcha" : captchaInput.value,
                "file" : imageInput.value
            })
            .then(function(response){
                console.log(response);
            })
        })
    </script>
</div>
