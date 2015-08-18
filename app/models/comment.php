<?php

class Comment extends AppModel
{
	public $validation = array(
		'username' => array(
			'length' => array(
				'validate_between', 1, 16,
				),
			),
		'body' => array(
			'length' => array(
				'validate_between', 1, 200,
				),
			),
		);

	public function getAll()
	{
		$comments = array();
		$thread = Param::get('thread_id');
		$db = DB::conn();

		$rows = $db->rows(
		'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC', array($thread));

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
} 