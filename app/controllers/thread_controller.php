<?php
class ThreadController extends AppController
{
    CONST MAX_THREADS_PER_PAGE = 15;
    public function index()
    {
        session_start();
        
        $page = Param::get('page', 1);
        $pagination = new SimplePagination($page, self::MAX_THREADS_PER_PAGE);

        $threads = Thread::getAll($pagination->start_index -1, $pagination->count + 1);
        $pagination->checkLastPage($threads);
        $total = Thread::countAll();
        $pages = ceil($total/self::MAX_THREADS_PER_PAGE);

        $this->set(get_defined_vars());
    }

    public function create()
    {
        session_start();
        
        $thread = new Thread();
        $comment = new Comment();
        $page = Param::get('page_next', 'create');

        switch($page) {
            case 'create':
                break;
            case 'create_end':
                $thread->title = Param::get('title');
                $comment->username = $_SESSION['username'];
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