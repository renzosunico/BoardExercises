<h1 class="white" style="text-align: center">Threads</h1>
    <?php if(empty($threads)): ?>
        <div class="well offset-left lineheight" onclick="location.href='<?php encode_quotes(url('thread/index')) ?>'" style="cursor:pointer;">
            <p class="listmargin">No available threads. ☹☹☹</p>
        </div>
    <?php endif ?>
    <?php foreach($threads as $v): ?>
        <div class="well offset-left lineheight" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>'" style="cursor:pointer;">
            <p class="smallsize">Posted: <?php echo readable_text(date("l, F d, Y h:i a", strtotime($v->created))); ?> </p>
            <hr>
            <p class="listmargin"> <?php encode_quotes($v->title) ?> </p>
        </div>
    <?php endforeach ?>

<div class="well">
    <?php if($pages > 1): ?>
        <?php if($pagination->current > 1): ?>
            <a href='?page=<?php echo $pagination->prev ?>'>Previous</a>
        <?php else: ?>
            Previous
        <?php endif ?>

        <?php for($i = 1; $i <= $pages; $i++): ?>
            <?php if($i == $page): ?>
                <?php echo $i ?>
            <?php else: ?>
                <a href='?page=<?php echo $i ?>'><?php echo $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if(!$pagination->is_last_page): ?>
            <a href='?page=<?php echo $pagination->next ?>'>Next</a>
        <?php else: ?>
            Next
        <?php endif ?>
    <?php endif ?>

    <br/><br/>
    <a class="btn btn-large btn-primary span3 middle" href="<?php encode_quotes(url('thread/create')) ?>">Create</a>
    <br/><br/>
</div>