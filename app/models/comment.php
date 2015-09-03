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

        $fetch_query = "SELECT * FROM comment WHERE thread_id = ? ORDER BY created LIMIT {$offset},{$limit}";
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
        return $db->value(
            sprintf("SELECT body FROM comment WHERE thread_id=%d LIMIT %d", $thread_id, self::FIRST_COMMENT)
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
        $db = DB::conn();
        $db->update('comment', array('body' => $this->body), array('id' => $this->id));
    }
} 