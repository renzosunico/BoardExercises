<?php
class CommentController extends AppController
{
    const MAX_ITEM_PER_PAGE         = 10;
    const CURRENT_PAGE_WRITE        = 'write';
    const RENDER_PAGE_AFTER_WRITE   = 'write_end';
    const METHOD_LIKE               = 'like';
    const METHOD_UNLIKE             = 'unlike';
    const AUTH_COMMENT_EDIT         = 'comment';
    const AUTH_COMMENT_DELETE       = 'comment';

    public function view()
    {
        $thread = Thread::getById(Param::get('thread_id'));

        $page = Param::get('page', 1);
        $pagination = new SimplePagination($page, self::MAX_ITEM_PER_PAGE);

        $filter_username = htmlentities(Param::get('username'));

        $comments = Comment::getAll(
            $pagination->start_index-1,
            $pagination->count+1,
            $thread->id,
            $filter_username
        );

        $pagination->checkLastPage($comments);

        Comment::getUserAttributes($comments, $_SESSION['userid']);

        Comment::sortByLikes($comments, Param::get('sort'));

        $total = Comment::countAll();
        $pages = ceil($total / self::MAX_ITEM_PER_PAGE);

        $this->set(get_defined_vars());
    }

    public function write()
    {
        $thread = Thread::getById(Param::get('thread_id'));
        $comment = new Comment();
        $page = Param::get('page_next','write');

        switch ($page) {
            case self::CURRENT_PAGE_WRITE:
                break;
            case self::RENDER_PAGE_AFTER_WRITE:
                $comment->id      = $thread->id;
                $comment->user_id = get_authenticated_user_id($_SESSION['userid']);
                $comment->body    = Param::get('body');
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
        $thread_id  = Param::get('thread_id');
        $comment_id = Param::get('comment_id');
        $process    = Param::get('process');
        $user_id    = get_authenticated_user_id($_SESSION['userid']);

        switch ($process) {
            case self::METHOD_LIKE:
                Likes::setLike($comment_id, $user_id);
                break;
            case self::METHOD_UNLIKE:
                Likes::unsetLike($comment_id, $user_id);
                break;
            default:
                redirect(NOT_FOUND_PAGE);
        }

        redirect(VIEW_COMMENT_PAGE, array('thread_id' => $thread_id));
    }

    public function edit()
    {
        $thread_id        = Param::get('thread_id');
        $comment          = new Comment();
        $comment->id      = Param::get('comment_id');
        $comment->user_id = get_authenticated_user_id($_SESSION['userid']);
        $comment->body    = Param::get('body');

        authorize_user_request($comment->id, self::AUTH_COMMENT_EDIT);

        try {
            $comment->edit();
        } catch(ValidationException $e) {
            $_SESSION['old_comment'] = (array)$comment;
        }

        redirect(VIEW_COMMENT_PAGE, array('thread_id' => $thread_id));
    }

    public function delete()
    {
        $thread_id  = Param::get('thread_id');
        $comment_id = Param::get('comment_id');
        authorize_user_request($comment_id, self::AUTH_COMMENT_DELETE);
        try {
            Comment::delete($comment_id, $thread_id);
        } catch(PDOException $e) {
            $_SESSION['delete_error'] = true;
        }

        redirect(VIEW_COMMENT_PAGE, array('thread_id' => $thread_id));
    }
}
