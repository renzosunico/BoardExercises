<h2><?php eh($thread->title) ?></h2>

<p class="alert alert-sucess">
	You successfully created.
</p>

<a href="<?php eh(url('thread/view', array('thread_id' => $comment->id))) ?>">
	&larr; Go to thread
</a>