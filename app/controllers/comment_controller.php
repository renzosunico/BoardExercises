<?php
class CommentController extends AppController
{
    CONST MAX_ITEM_PER_PAGE = 10;

    public function view()
    {
        $thread = Thread::getById(Param::get('thread_id'));
        $comment = new Comment();

        $page = Param::get('page', 1);
        $pagination = new SimplePagination($page, self::MAX_ITEM_PER_PAGE);

        $comments = $comment->getAll($pagination->start_index-1, $pagination->count+1, $thread->id);
        $pagination->checkLastPage($comments);

        $total = Comment::countAll();
        $pages = ceil($total / self::MAX_ITEM_PER_PAGE);

        $starting_index = (($page-1)*self::MAX_ITEM_PER_PAGE);

        $this->set(get_defined_vars());
    }

    public function write()
    {
        $thread = Thread::getById(Param::get('thread_id'));
        $comment = new Comment();
        $page = Param::get('page_next','write');

        switch($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->id = $thread->id;
                $comment->username = $_SESSION['username'];
                $comment->body = Param::get('body');
                try {
                $comment->write();
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