<div class="d-flex f-column f-center">
    <p>[{{$thread ? "Post a Reply" : "Create new Thread"}}]</p>
    <form action="{{ $thread ? route('post', ['boardName' => $thread->getBoardName()]) : "Create new Thread" }}">
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
                        <input type="text" name="options" id="options"tabindex="3" >
                    </td>
                </tr>
                <tr data-type="subject">
                    <td class="label">
                        Subject
                    </td>
                    <td>
                        <input type="text" name="subject" id="subject" tabindex="3" >
                        <input type="submit" value="Post" tabindex="3">
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
                        <input type="text" name="verification" id="verification" placeholder="Coming Soon">
                    </td>
                </tr>
                <tr data-type="file">
                    <td class="label">
                        File
                    </td>
                    <td>
                        <input type="file" name="file" id="file">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
