<?php
class Comment extends AppModel
{
    public $validation = array(
        'body' => array(
            'length' => array(
                'validate_between', 1, 200,
                ),
            ),
        );

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
        return $db->value("SELECT COUNT(*) FROM comment WHERE thread_id = {$id}");
    }

    public function write()
    {
        if(!$this->validate()) {
            throw new ValidationException('Invalid comment.');
        }

        $params = array(
            'thread_id' => $this->id,
            'username' => $this->username,
            'body' => $this->body
            );

        $db = DB::conn();
        $db->insert('comment',$params);
    }
} 