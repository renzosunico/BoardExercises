<?php
class CommentController extends AppController
{
    CONST MAX_ITEM_PER_PAGE = 10;
    CONST SORT_TYPE_COMMENT = 'comment';
    CONST CURRENT_PAGE_WRITE = 'write';
    CONST RENDER_PAGE_AFTER_WRITE = 'write_end';
    CONST METHOD_LIKE = 'like';
    CONST METHOD_UNLIKE = 'unlike';

    public function view()
    {
        $thread = Thread::getById(Param::get('thread_id'));
        $comment = new Comment();

        $page = Param::get('page', 1);
        $pagination = new SimplePagination($page, self::MAX_ITEM_PER_PAGE);

        $filter_username = htmlentities(Param::get('username'));

        $comments = $comment->getAll($pagination->start_index-1, $pagination->count+1, $thread->id, $filter_username);
        $pagination->checkLastPage($comments);

        $comment->getUserAttributes($comments, $_SESSION['userid']);

        $sort = Param::get('sort');

        if($sort === self::SORT_TYPE_COMMENT) {
            usort($comments, function($a , $b) {
                return $b->likecount - $a->likecount;
            });
        }

        $total = Comment::countAll();
        $pages = ceil($total / self::MAX_ITEM_PER_PAGE);

        $starting_index = (($page-1) * self::MAX_ITEM_PER_PAGE);

        $this->set(get_defined_vars());
    }

    public function write()
    {
        $thread = Thread::getById(Param::get('thread_id'));
        $comment = new Comment();
        $page = Param::get('page_next','write');

        switch($page) {
            case self::CURRENT_PAGE_WRITE:
                break;
            case self::RENDER_PAGE_AFTER_WRITE:
                $comment->id = $thread->id;
                $comment->user_id = User::getIdByUsername($_SESSION['username']);
                $comment->body = Param::get('body');
                try {
                    $comment->write();
                } catch (ValidationException $e) {
                    $page = self::CURRENT_PAGE_WRITE;
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function like()
    {
        $thread_id = Param::get('thread_id');
        $comment_id = Param::get('comment_id');
        $process = Param::get('process');
        
        switch($process) {
            case self::METHOD_LIKE:
                Likes::setLike($comment_id, $_SESSION['userid']);
                break;
            case self::METHOD_UNLIKE:
                Likes::unsetLike($comment_id, $_SESSION['userid']);
                break;
            default:
                redirect('notfound/pagenotfound');
        }

        redirect('comment/view', array('thread_id' => $thread_id));
    }

    public function edit()
    {
        $thread_id = Param::get('thread_id');
        $comment = new Comment();
        $comment->id = Param::get('comment_id');
        $comment->user_id = $_SESSION['userid'];
        $comment->body = Param::get('body');

        authorize_user_request($comment->id, 'comment');

        try {
            $comment->edit();
        } catch(ValidationException $e) {
            $_SESSION['old_comment'] = (array)$comment;
        }

        redirect('comment/view', array('thread_id' => $thread_id));
    }

    public function delete()
    {
        $comment_id = Param::get('comment_id');
        authorize_user_request($comment_id, 'comment');
        $thread_id = Param::get('thread_id');
        try {
            Comment::delete($comment_id, $thread_id);
        } catch(PDOException $e) {
            $_SESSION['delete_error'] = true;
        }

        redirect('comment/view', array('thread_id' => $thread_id));
    }
}