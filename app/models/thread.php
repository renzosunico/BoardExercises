<?php
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between',1,30,
                ),
            ),
        );
    
    public static function get($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id=?', array($id));

        if(!$row) {
            throw new RecordNotFoundException('No record found.');
        }
        return new self($row);
    }

    public static function getAll($offset, $limit)
    {
        $threads = array();
        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM thread LIMIT {$offset}, {$limit}");

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

    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();

        if($this->hasError() || $comment->hasError()) {
            throw new ValidationException('Invalid thread or comment.');
        }

        $params = array(
            'title' => $this->title,
            'created' => date('Y-m-d H:i:s')
            );

        $db = DB::conn();
        $db->begin();
        $db->insert('thread', $params);
        $comment->id = $db->lastInsertId();

        $comment->write($comment);

        $db->commit();
    }
}