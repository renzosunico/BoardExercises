<?php
class Likes extends AppModel
{
    const TABLE_NAME = 'likes';

    public static function isLiked($comment_id, $session_user)
    {
        $db = DB::conn();
        $params = array(
            $comment_id,
            $session_user
        );
        return $db->row("SELECT * FROM likes WHERE comment_id = ? AND user_id = ?", $params);
    }

    public static function setLike($comment_id, $session_user)
    {
        $db = DB::conn();
        $params = array(
            'comment_id' => $comment_id,
            'user_id'    => $session_user
        );

        try {
            $db->insert(self::TABLE_NAME, $params);
        } catch (PDOException $e) {
        }

    }

    public static function unsetLike($comment_id, $session_user)
    {
        $db = DB::conn();
        $params = array(
            $comment_id,
            $session_user
        );
        $db->query("DELETE FROM likes WHERE comment_id = ? AND user_id = ?", $params);

    }

    public static function countLike($comment_id)
    {
        $db = DB::conn();
        return $db->value("SELECT COUNT(*) FROM likes WHERE comment_id = ?", array($comment_id));
    }
}
