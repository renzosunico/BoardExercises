<?php

class ThreadController extends AppController
{
	public function index()
	{
		$page = Param::get('page', 1);
		$per_page = 15;
		$pagination = new SimplePagination($page, $per_page);

		$threads = Thread::getAll($pagination->start_index -1, $pagination->count + 1);
		$pagination->checkLastPage($threads);
		$total = Thread::countAll();
		$pages = ceil($total/$per_page);

		$this->set(get_defined_vars());
	}

	public function view()
	{
		$thread = Thread::get(Param::get('thread_id'));
		$comment = new Comment();
		$comments = $comment->getAll();

		$this->set(get_defined_vars());
	}

/*	public function write()
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
				$thread->write($comment);
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
*/
	public function create()
	{
		$thread = new Thread();
		$comment = new Comment();
		$page = Param::get('page_next', 'create');

		switch($page) {
			case 'create':
				break;
			case 'create_end':
				$thread->title = Param::get('title');
				$comment->username = Param::get('username');
				$comment->body = Param::get('body');
				try {
					$thread->create($comment);
				} catch(ValidationException $e) {
					$page = 'create';
				}
				break;
			default:
				throw new NotFoundException("{$page} is not found");
		}
		$this->set(get_defined_vars());
		$this->render($page);
	}
}