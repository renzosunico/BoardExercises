<?php

class CommentController extends AppController
{
	public function write()
	{
		$thread = Thread::get(Param::get('thread_id'));
		$comment = new Comment();
		$page = Param::get('page_next');

		switch($page) {
			case 'write':
				break;
			case 'write_end':
				$comment->id = $thread->id;
				$comment->username = Param::get('username');
				$comment->body = Param::get('body');
				try {
				$comment->write($comment);
				} catch (ValidationException $e) {
					$page = 'write';
				}
				break;

			default:
				throw new NotFoundException("{$page} is not found");
				break;
		}

		$this->set(get_defined_vars());
		$this->render($page);
	}
}