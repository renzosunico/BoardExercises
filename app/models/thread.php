<?php
class Thread extends AppModel
{
    CONST TREND_LIMIT = 10;
    CONST TABLE_NAME = 'thread';
    CONST MIN_TITLE_LENGTH = 1;
    CONST MAX_TITLE_LENGTH = 30;

    public $validation  =  array(
        'title'         => array(
            'length'    => array('validate_between', self::MIN_TITLE_LENGTH, self::MAX_TITLE_LENGTH),
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

        if(!$row) {
            throw new RecordNotFoundException('No record found.');
        }
        return new self($row);
    }

    public static function getAll($offset, $limit, $order)
    {
        $threads = array();
        $db = DB::conn();
        $rows = $db->rows(sprintf("SELECT * FROM thread ORDER BY %s LIMIT %d,%d ",
            $order, $offset, $limit)
        );

        foreach($rows as $row) {
            $threads[] = new self($row);
        }

        return $threads;
    }

    public static function countAll()
    {
        $db = DB::conn();
        return (int)$db->value("SELECT COUNT(*) FROM thread");
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
                'title'         =>      $this->title,
                'user_id'       =>      $this->user_id,
                'category_name' =>      $this->category
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

        if($this->hasError() || $comment->hasError()) {
            throw new ValidationException('Invalid thread or comment.');
        }

        $db = DB::conn();
        $db->begin();
        try {

            $db->query("UPDATE thread SET title=?, category_name=?, last_modified=NOW() WHERE id=?",
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
        $db->query("DELETE FROM thread where id = ?", array($thread_id));
    }

    public function isAuthor()
    {
        return $this->user_id === $_SESSION['userid'];
    }

    public static function hasThread($user_id)
    {
        $db = DB::conn();
        return $db->rows("SELECT id FROM thread WHERE user_id = ?", array($user_id));
    }

    public static function getByUserId($user_id)
    {
        $db = DB::conn();
        $threads = array();
        $rows = $db->rows("SELECT * FROM thread WHERE user_id = ?", array($user_id));

        foreach ($rows as $row) {
            $threads[] = new self($row);
        }

        return $threads;
    }

    public static function getTrending()
    {
        $db = DB::conn();
        return $db->rows(
            sprintf("select thread_id, count(*) AS count
            FROM comment GROUP BY thread_id
            ORDER BY count DESC, created LIMIT %d", self::TREND_LIMIT)
        );
    }

    public static function getTitleById($thread_id)
    {
        $db = DB::conn();
        return $db->value("SELECT title FROM thread WHERE id = ?", array($thread_id));
    }

    public static function getUsernameComment($threads)
    {
        foreach ($threads as $thread) {
            $thread->username = User::getUsernameById($thread->user_id);
            $thread->comment = Comment::getByThreadId($thread->id);
        }
    }

    public static function getTrendTitle(&$trending_ids)
    {
        foreach ($trending_ids as &$thread) {
            $thread['title'] = Thread::getTitleById($thread['thread_id']);
        }
    }
}