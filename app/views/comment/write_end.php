<div class="well well-large">
    <div class="alert alert-success">
        <span class="glyphicon glyphicon-ok-circle"></span> You have successfully wrote this comment.
    </div>
    <button class="btn btn-primary" type="submit" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $thread->id))) ?>'">&larr; Back to thread</button>
</div>
