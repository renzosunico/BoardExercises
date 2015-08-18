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
			$threads[] = new Thread($row);
		}

		return $threads;
	}

	public static function countAll()
	{
		$db = DB::conn();
		return (int)$db->value("SELECT COUNT(*) FROM thread");
	}

/*	public function getComments()
	{
		$comments = array();
		$db = DB::conn();

		$rows = $db->rows(
		'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC', array($this->id));

		foreach ($rows as $row) {
			$comments[] = new Comment($row);
		}

		return $comments;
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
*/
	public function create(Comment $comment)
	{
		$this->validate();
		$comment->validate();

		if($this->hasError() || $comment->hasError()) {
			throw new ValidationException('Invalid thread or comment.');
		}

		$db = DB::conn();
		$db->begin();
		$db->query('INSERT INTO thread SET title = ?, created = NOW()', array($this->title));
		$comment->id = $db->lastInsertId();

		$comment->write($comment);

		$db->commit();
	}
}