<?php
class ThreadController extends AppController
{
    CONST MAX_THREADS_PER_PAGE = 15;
    
    public function index()
    {
        $page = Param::get('page', 1);
        $pagination = new SimplePagination($page, self::MAX_THREADS_PER_PAGE);

        $threads = Thread::getAll($pagination->start_index -1, $pagination->count + 1);
        $pagination->checkLastPage($threads);

        foreach ($threads as $thread) {
            $thread->user_id = User::getUsernameById($thread->user_id);
        }


        $total = Thread::countAll();
        $pages = ceil($total/self::MAX_THREADS_PER_PAGE);

        $this->set(get_defined_vars());
    }

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
                $thread->user_id = User::getIdByUsername($_SESSION['username']);
                $thread->category = Param::get('category');
                $comment->user_id = User::getIdByUsername($_SESSION['username']);
                $comment->body = Param::get('body');
                try {
                    $thread->create($comment);
                } catch(ValidationException $e) {
                    $page = 'create';
                }
                break;
            default:
                throw new RecordNotFoundException("{$page} is not found");
        }

        if($page === 'create_end') {
            redirect('comment/view', array('thread_id' => $comment->id));
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function edit()
    {
        $thread_id = Param::get('thread_id');
        authorize_user_request($thread_id, 'edit');

        $thread = new Thread();
        $comment = new Comment();

        $thread->id = $thread_id;
        $thread->title = Param::get('title');
        $thread->category = Param::get('category');
        $comment->id = Comment::getIdByThreadId($thread->id);
        $comment->body = Param::get('body');

        try {
            $thread->edit($comment);
        } catch (ValidationException $e) {
            $_SESSION['editHasError'] = true;
        }

        redirect('thread/index');
    }

    public function delete()
    {
        $thread_id = Param::get('thread_id');
        authorize_user_request($thread_id, 'edit');

        try {
            Thread::delete($thread_id);
        } catch (PDOException $e) {
            $_SESSION['deleteHasError'] = true;
            echo $e; die();
        }

        redirect('thread/index');
        
    }
}