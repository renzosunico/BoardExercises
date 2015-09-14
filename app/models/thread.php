<?php
class Thread extends AppModel
{
    const TABLE_NAME = 'thread';
    const MIN_TITLE_LENGTH = 1;
    const MAX_TITLE_LENGTH = 30;

    public $validation  =  array(
        'title'         => array(
            'length'    => array('validate_between',
                self::MIN_TITLE_LENGTH,
                self::MAX_TITLE_LENGTH
            ),
            'chars'     => array('validate_space_only'),
        ),
        'category'      => array(
            'content'   => array('validate_content'),
        ),
    );
    
    public static function getById($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id=?', array($id));

        if (!$row) {
            throw new RecordNotFoundException('No record found.');
        }
        return new self($row);
    }

    public static function getAll($offset, $limit, $order)
    {
        $threads = array();
        $db = DB::conn();
        $rows = $db->rows(sprintf("SELECT * FROM thread ORDER BY %s LIMIT %d,%d ",
            $order,
            $offset,
            $limit
            )
        );

        foreach($rows as $row) {
            $threads[] = new self($row);
        }

        return $threads;
    }

    public static function countAll()
    {
        $db = DB::conn();
        return $db->value("SELECT COUNT(*) FROM thread");
    }

    public function create(Comment &$comment)
    {
        $this->validate();
        $comment->validate();

        if($this->hasError() || $comment->hasError()) {
            throw new ValidationException('Invalid thread or comment.');
        }

        $db = DB::conn();
        $db->begin();
        try {
            $params = array(
                'title'         =>   $this->title,
                'user_id'       =>   $this->user_id,
                'category_name' =>   $this->category
            );
            $db->insert(self::TABLE_NAME, $params);
            $comment->id = $db->lastInsertId();
            $comment->write();
            $db->commit();
        } catch (PDOException $e) {
            $db->rollback();
        }
    }

    public function edit(Comment &$comment)
    {
        $this->validate();
        $comment->validate();

        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('Invalid thread or comment.');
        }

        $db = DB::conn();
        $db->begin();
        try {

            $db->query("UPDATE thread SET title=?, category_name=?,
                last_modified=NOW() WHERE id=?",
                array($this->title, $this->category, $this->id)
            );

            $comment->edit();
            $db->commit();
        } catch (PDOException $e) {
            $db->rollback();
        }
    }

    public static function getAuthorById($id)
    {
        $db = DB::conn();
        return $db->value("SELECT user_id FROM thread WHERE id=?", array($id));
    }

    public static function delete($thread_id)
    {
        $db = DB::conn();
        $db->query("DELETE FROM thread WHERE id = ?", array($thread_id));
    }

    public function isAuthor($session_user)
    {
        return $this->user_id === $session_user;
    }

    public static function hasThread($user_id)
    {
        $db = DB::conn();
        return $db->rows("SELECT id FROM thread WHERE user_id = ?",
            array($user_id)
        );
    }

    public static function getByUserId($user_id)
    {
        $db = DB::conn();
        $threads = array();
        $rows = $db->rows("SELECT * FROM thread WHERE user_id = ?",
            array($user_id)
        );

        foreach ($rows as $row) {
            $threads[] = new self($row);
        }

        return $threads;
    }

    public static function getTitleById($thread_id)
    {
        $db = DB::conn();
        return $db->value("SELECT title FROM thread WHERE id = ?",
            array($thread_id)
        );
    }

    public static function getAttributes($threads, $session_user)
    {
        foreach ($threads as $thread) {
            $thread->username    = User::getUsernameById($thread->user_id);
            $thread->comment     = Comment::getByThreadId($thread->id);
            $thread->is_author   = $thread->isAuthor($session_user);
            $thread->is_followed = Follow::isFollowed($thread->id,
                $session_user
            );
        }
    }

    public static function getTrendTitle(&$trending_ids)
    {
        foreach ($trending_ids as &$thread) {
            $thread['title'] = Thread::getTitleById($thread['thread_id']);
        }
    }
}
