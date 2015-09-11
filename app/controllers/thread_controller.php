<?php
class ThreadController extends AppController
{
    CONST MAX_THREADS_PER_PAGE = 15;
    CONST FIRST_PAGE           = 1;
    CONST CREATE_PAGE          = 'create';
    CONST PAGE_AFTER_CREATE    = 'create_end';
    CONST PROFILE_PAGE         = 'profile';
    CONST PROCESS_FOLLOW     = 'follow';
    CONST PROCESS_UNFOLLOW     = 'unfollow';
    CONST AUTH_THREAD_EDIT     = 'thread';
    CONST AUTH_THREAD_DELETE   = 'thread';
    
    public function index()
    {
        $page        = Param::get('page', self::FIRST_PAGE);
        $sort_method = Param::get('sort', 'created');
        $user_id     = get_authenticated_user_id($_SESSION['userid']);
        $pagination  = new SimplePagination($page, self::MAX_THREADS_PER_PAGE);

        $threads = Thread::getAll(
            $pagination->start_index - 1,
            $pagination->count + 1,
            $sort_method
        );
        
        $pagination->checkLastPage($threads);

        Thread::getAttributes($threads, $user_id);

        $trending_threads = Thread::getTrending();
        Thread::getTrendTitle($trending_threads);

        $total = Thread::countAll();
        $pages = ceil($total / self::MAX_THREADS_PER_PAGE);

        $this->set(get_defined_vars());
    }

    public function create()
    {
        $thread = new Thread();
        $comment = new Comment();

        $page    = Param::get('page_next', 'create');
        $user_id = get_authenticated_user_id($_SESSION['userid']);

        switch ($page) {
            case self::CREATE_PAGE:
                break;
            case self::PAGE_AFTER_CREATE:
                $thread->title    = Param::get('title');
                $thread->user_id  = $user_id;
                $thread->category = Param::get('category');
                $comment->user_id = $user_id;
                $comment->body    = Param::get('body');
                try {
                    $thread->create($comment);
                } catch(ValidationException $e) {
                    $page = self::CREATE_PAGE;
                }
                break;
            default:
                throw new RecordNotFoundException("{$page} is not found");
        }

        if ($page === self::PAGE_AFTER_CREATE) {
            redirect('comment/view', array('thread_id' => $comment->id));
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function edit()
    {
        $thread_id = Param::get('thread_id');
        $user_id   = get_authenticated_user_id($_SESSION['userid']);
        authorize_user_request($thread_id, self::AUTH_THREAD_EDIT);

        $thread  = new Thread();
        $comment = new Comment();

        $thread->id       = $thread_id;
        $thread->title    = Param::get('title');
        $thread->category = Param::get('category');
        $comment->id      = Comment::getIdByThreadId($thread->id);
        $comment->body    = Param::get('body');

        try {
            $thread->edit($comment);
        } catch (ValidationException $e) {
            $_SESSION['old_thread']  = (array)$thread;
            $_SESSION['old_comment'] = (array)$comment;
        }

        $page_to_go = Param::get('page');

        if ($page_to_go === self::PROFILE_PAGE) {
            redirect('user/profile', array("user_id" => $user_id));
        }

        redirect('thread/index');
    }

    public function delete()
    {
        $thread_id = Param::get('thread_id');
        authorize_user_request($thread_id, self::AUTH_THREAD_DELETE);
        $user_id = get_authenticated_user_id($_SESSION['userid']);

        try {
            Thread::delete($thread_id);
        } catch (PDOException $e) {
            $_SESSION['deleteHasError'] = true;
        }

        $page_to_go = Param::get('page');

        if ($page_to_go === self::PROFILE_PAGE) {
            redirect('user/profile', array("user_id" => $user_id));
        }

        redirect('thread/index');
    }

    public function follow()
    {
        $thread_id = Param::get('thread_id');
        $process = Param::get('process');
        $user_id = get_authenticated_user_id($_SESSION['userid']);

        switch ($process) {
            case self::PROCESS_FOLLOW:
                Follow::setFollow($thread_id, $user_id);
                break;
            case self::PROCESS_UNFOLLOW:
                Follow::unsetFollow($thread_id, $user_id);
                break;
            default:
                redirect('notfound/pagenotfound');
        }

        $page = Param::get('page');
        $user_id = Param::get('user_id');

        if ($page) {
            redirect($page, array('user_id' => $user_id));
        }

        redirect('thread/index');
    }
}
