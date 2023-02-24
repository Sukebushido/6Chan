<form action="" id="reply_form" class="reply-box">
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
        <button type="submit">Post</button>
    </div>
</form>
