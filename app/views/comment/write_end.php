<h2><?php eh($thread->title) ?><h2>

<p class="alert alert-sucess">
	You sucessfully wrote this comment.
</p>

<a href="<?php eh(url('comment/view', array('thread_id' => $thread->id))) ?>">
	&larr; Back to thread.
</a>