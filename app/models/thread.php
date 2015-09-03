<?php
class Thread extends AppModel
{
    public $validation  =  array(
        'title'         => array(
            'length'    => array('validate_between', 1, 30,),
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
            $db->insert('thread', $params);
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
            $params = array(
                'title'         =>  $this->title,
                'category_name' =>  $this->category
            );
            $db->update('thread', $params, array('id' => $this->id));
            $comment->edit();
            $db->commit();
        } catch (PDOException $e) {
            echo "gogo" . $e; die();
            $db->rollback();
        }
    }

    public static function getAuthorById($id)
    {
        $db = DB::conn();
        return $db->value("SELECT user_id FROM thread WHERE id=?", array($id));
    }
}