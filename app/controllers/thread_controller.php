<?php
class ThreadController extends AppController
{
    CONST MAX_THREADS_PER_PAGE = 15;
    
    public function index()
    {
        $page = Param::get('page', 1);
        $sort_method = Param::get('sort','created');
        $pagination = new SimplePagination($page, self::MAX_THREADS_PER_PAGE);

        $threads = Thread::getAll($pagination->start_index -1, $pagination->count + 1, $sort_method);
        $pagination->checkLastPage($threads);

        foreach ($threads as $thread) {
            $thread->username = User::getUsernameById($thread->user_id);
        }

        $trending_threads = Thread::getTrending();

        foreach ($trending_threads as &$thread) {
            $thread['title'] = Thread::getTitleById($thread['thread_id']);
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
        authorize_user_request($thread_id, 'thread');

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
        authorize_user_request($thread_id, 'thread');

        try {
            Thread::delete($thread_id);
        } catch (PDOException $e) {
            $_SESSION['deleteHasError'] = true;
            echo $e; die();
        }

        redirect('thread/index');
    }

    public function follow()
    {
        $thread_id = Param::get('thread_id');
        $process = Param::get('process');

        switch ($process) {
            case 'follow':
                Follow::setFollow($thread_id, $_SESSION['userid']);
                break;
            case 'unfollow':
                Follow::unsetFollow($thread_id, $_SESSION['userid']);
                break;
            default:
                redirect('notfound/pagenotfound');
        }

        $page = Param::get('page');
        $user_id = Param::get('user_id');

        if($page) {
            redirect($page, array('user_id' => $user_id));
        }

        redirect('thread/index');
    }
}