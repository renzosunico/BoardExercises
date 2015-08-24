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

    public function getAll($offset, $limit)
    {
        $comments = array();
        $thread = Param::get('thread_id');
        $db = DB::conn();

        $rows = $db->rows(
        "SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC LIMIT {$offset},{$limit}", array($thread));

        foreach ($rows as $row) {
            $comments[] = new self($row);
        }

        return $comments;
    }

    public static function countAll()
    {
        $db = DB::conn();
        $id = Param::get('thread_id');
        return (int)$db->value("SELECT COUNT(*) FROM comment WHERE thread_id = {$id}");
    }

    public function write(Comment $comment)
    {
        if(!$comment->validate()) {
            throw new ValidationException('Invalid comment.');
        }
        $db = DB::conn();
        $db->query(
        'INSERT INTO comment SET thread_id = ?, username = ?, body = ?, created = NOW()',
        array($comment->id, $comment->username, $comment->body)
        );
    }
} 