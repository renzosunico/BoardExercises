<h1 class="white"><?php encode_quotes($thread->title) ?></h1>

<div class="well">

<?php foreach($comments as $k => $v): ?>

<div class="comment">

<div class="meta">
    <?php encode_quotes(++$starting_index) ?>: <?php encode_quotes($v->user_id) ?> <?php encode_quotes($v->created) ?>
</div>

<div><?php echo readable_text($v->body) ?></div>

</div>

<?php endforeach ?>

<hr>

    <?php foreach ($comments as $comment): ?>
         <a href="<?php readable_text(url('comment/view', array('user_id' => $comment->user_id))) ?>">
         <?php readable_text($comment->username) ?></a> 
         <?php readable_text($comment->body) ?>
     <?php endforeach ?>

<div class="pagination pagination-centered">
    <?if ($pages > 1): ?>
    <ul>
            <?php if($pagination->current > 1): ?>
                <li><a href="?thread_id=<?php echo $thread->id ?>
                &page=<?php echo $pagination->prev ?>">Previous</a></li>
            <?php else: ?>
                <li class="disabled"><a href="#">Previous</a></li>
            <?php endif ?>

            <?php for($i=1; $i<=$pages; $i++): ?>
                <?php if($i == $page): ?>
                    <li class="disabled"><a href="#"><?php echo $i ?></a></li>
                <?php else: ?>
                    <li><a href="?thread_id=<?php echo $thread->id ?>
                        &page=<?php echo $i ?>"?><?php echo $i ?>
                    </a></li>
                <?php endif ?>
            <?php endfor ?>

            <?php if(!$pagination->is_last_page): ?>
                <li><a href="?thread_id=<?php echo $thread->id ?>
                    &page=<?php echo $pagination->next ?>">Next</a></li>
            <?php else: ?>
                <li class="disabled"><a href="#">Next</a></li>
            <?php endif ?>
        <?php endif ?>
    </ul>
</div>
<hr>
<a href="<?php encode_quotes(url('thread/index')) ?>" class="btn btn-default">Back to Thread</a>

</div>

<form class="well" method="post" action="<?php encode_quotes(url('comment/write')) ?>">
    <label>Comment</label>
    <textarea class="span4" name="body"><?php encode_quotes(Param::get('body')) ?></textarea>
    <input type="hidden" name="thread_id" value="<?php encode_quotes($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-primary">Comment</button>
</form>