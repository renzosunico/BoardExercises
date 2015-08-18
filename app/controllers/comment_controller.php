<?php

class CommentController extends AppController
{
	CONST MAX_ITEM_PER_PAGE = 5;


	public function view()
	{
		$page = Param::get('page', 1);
		$pagination = new SimplePagination($page, self::MAX_ITEM_PER_PAGE);

		$thread = Thread::get(Param::get('thread_id'));
		$comment = new Comment();

		$comments = $comment->getAll($pagination->start_index-1, $pagination->count+1);
		$pagination->checkLastPage($comments);

		$total = Comment::countAll();
		$pages = ceil($total / self::MAX_ITEM_PER_PAGE);

		$starting_index = (($page-1)*self::MAX_ITEM_PER_PAGE) + 1;

		$this->set(get_defined_vars());
	}

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