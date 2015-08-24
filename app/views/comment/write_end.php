<h2 class="white"><?php eh($thread->title) ?></h2>
<div class="well well-large">
    <div class="alert alert-success">You have successfully wrote this comment.</div>
    <button class="btn btn-primary" type="submit" onclick="location.href='<?php eh(url('comment/view', array('thread_id' => $thread->id))) ?>'">&larr; Back to thread</button>
</div>