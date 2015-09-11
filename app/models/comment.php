<?php
class Comment extends AppModel
{
    CONST MIN_BODY_LENGTH   = 1;
    CONST MAX_BODY_LENGTH   = 200;
    CONST TABLE_NAME        = 'comment';
    CONST SORT_TYPE_COMMENT = 'comment';

    public $validation = array(
        'body'       => array(
            'length' => array(
                'validate_between',
                self::MIN_BODY_LENGTH,
                self::MAX_BODY_LENGTH
            ),
            'chars'  => array('validate_space_only'),
        ),
    );

    public static function getAll($offset, $limit, $thread_id, $filter_username)
    {
        $comments = array();
        $db = DB::conn();

        if(empty($filter_username)) {
            $fetch_query = sprintf(
                "SELECT * FROM comment WHERE thread_id = ?
                ORDER BY created LIMIT %d, %d", $offset, $limit
            );
            $rows = $db->rows($fetch_query, array($thread_id));
        } else {
            $user_id = $db->value(
                "SELECT id FROM user WHERE username LIKE ?",
                array("%$filter_username%")
            );

            $fetch_query = sprintf(
                "SELECT * FROM comment WHERE thread_id = ? AND user_id = ?
                ORDER BY created LIMIT %d, %d",
                $offset,
                $limit
            );
            $rows = $db->rows($fetch_query, array($thread_id, $user_id));
        }

        foreach ($rows as $row) {
            $comments[] = new self($row);
        }

        return $comments;
    }

    public static function countAll()
    {
        $db = DB::conn();
        $id = Param::get('thread_id');
        return $db->value("SELECT COUNT(*) FROM comment WHERE thread_id = ?", array($id));
    }

    public function write()
    {
        if(!$this->validate()) {
            throw new ValidationException('Invalid comment.');
        }

        $params = array(
            'thread_id' => $this->id,
            'user_id'   => $this->user_id,
            'body'      => $this->body
        );

        $db = DB::conn();
        $db->insert(self::TABLE_NAME, $params);
    }

    public static function getByThreadId($thread_id)
    {
        $db = DB::conn();
        return $db->row("SELECT * FROM comment WHERE thread_id = ?",
            array($thread_id)
        );
    }

    public static function getIdByThreadId($thread_id)
    {
        $db = DB::conn();
        return $db->value("SELECT id FROM comment WHERE thread_id = ?",
            array($thread_id)
        );
    }

    public function edit()
    {
        if (!$this->validate()) {
            throw new ValidationException;
        }

        $db = DB::conn();
        $db->query(
            "UPDATE comment SET body=?, last_modified=NOW() WHERE id=? AND user_id = ?",
            array($this->body, $this->id, $this->user_id)
        );
    }

    public function isAuthor($session_user)
    {
        $db = DB::conn();
        $params = array(
            $this->id,
            $session_user
        );
        return $db->search('comment', 'id = ? AND user_id = ?', $params);
    }

    public static function delete($comment_id, $thread_id)
    {
        $db = DB::conn();
        $params = array(
            $comment_id,
            $thread_id
        );
        $db->query("DELETE FROM comment WHERE id = ? AND $thread_id = ?", $params);
    }

    public static function getAuthorById($id)
    {
        $db = DB::conn();
        return $db->value("SELECT user_id FROM comment WHERE id=?", array($id));
    }

    public static function getUserAttributes($comments, $session_user)
    {
        foreach ($comments as $comment) {
            $comment->username  = User::getUsernameById($comment->user_id);
            $comment->likecount = Likes::countLike($comment->id);
            $comment->is_author = $comment->isAuthor($session_user);
            $comment->is_liked  = Likes::isLiked($comment->id, $session_user);
        }
    }

    public static function sortByLikes(&$comments, $sort)
    {
        if ($sort === self::SORT_TYPE_COMMENT) {
            usort($comments, function($a , $b) {
                return $b->likecount - $a->likecount;
            });
        }
    }
}
