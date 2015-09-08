<?php
class Likes extends AppModel
{
    public static function isLiked($thread_id)
    {
        $db = DB::conn();
        $params = array(
            $thread_id,
            $_SESSION['userid']
        );
        return $db->row("SELECT * FROM likes WHERE comment_id = ? AND user_id = ?", $params);
    }

    public static function setLike($comment_id, $thread_id)
    {
        $db = DB::conn();
        $params = array(
            'comment_id' => $comment_id,
            'user_id' => $_SESSION['userid'],
            'thread_id' => $thread_id
        );
        $db->insert('likes', $params);
    }

    public static function unsetLike($comment_id)
    {
        $db = DB::conn();
        $params = array(
            $comment_id,
            $_SESSION['userid']
        );
        $db->query("DELETE FROM likes WHERE comment_id = ? AND user_id = ?", $params);

    }

    public static function countLike($comment_id)
    {
        $db = DB::conn();
        return $db->value("SELECT COUNT(*) FROM likes WHERE comment_id = ?", array($comment_id));
    }
}