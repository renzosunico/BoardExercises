<?php
class Comment extends AppModel
{
    public $validation = array(
        'body'       => array(
            'length' => array('validate_between', 1, 200,),
        ),
    );

    CONST FIRST_COMMENT = 1;

    public function getAll($offset, $limit, $thread_id)
    {
        $comments = array();
        $db = DB::conn();
        $fetch_query = sprintf(
            "SELECT * FROM comment WHERE thread_id = ?
            ORDER BY created LIMIT %d, %d", $offset, $limit);
        $rows = $db->rows($fetch_query, array($thread_id));

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
            'user_id' => $this->user_id,
            'body' => $this->body
        );

        $db = DB::conn();
        $db->insert('comment',$params);
    }

    public static function getByThreadId($thread_id)
    {
        $db = DB::conn();
        return $db->row(
            sprintf("SELECT * FROM comment WHERE thread_id=%d LIMIT %d", $thread_id, self::FIRST_COMMENT)
        );
    }

    public static function getIdByThreadId($thread_id)
    {
        $db = DB::conn();
        return $db->value(
            sprintf("SELECT id FROM comment WHERE thread_id=%d LIMIT %d", $thread_id, self::FIRST_COMMENT)
        );
    }

    public function edit()
    {
        if(!$this->validate()) {
            throw new ValidationException;
        }

        $db = DB::conn();
        $db->query(
            "UPDATE comment SET body=?, last_modified=NOW() WHERE id=? AND user_id = ?",
            array($this->body, $this->id, $_SESSION['userid'])
        );
    }

    public function isAuthor()
    {
        $db = DB::conn();
        $params = array(
            $this->id,
            $_SESSION['userid']
        );
        return $db->search('comment', 'id = ? AND user_id = ?', $params);
    }

    public static function delete($comment_id, $thread_id)
    {
        $db = DB::conn();
        $params = array(
            $comment_id,
            $_SESSION['userid'],
            $thread_id
        );
        $db->query("DELETE FROM comment WHERE id = ? AND user_id = ? AND $thread_id = ?", $params);
    }

    public static function getAuthorById($id)
    {
        $db = DB::conn();
        return $db->value("SELECT user_id FROM comment WHERE id=?", array($id));
    }
} 