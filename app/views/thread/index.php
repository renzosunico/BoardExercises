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
    <div class="pagination pagination-centered">
        <?php if($pages > 1): ?>
        <ul>
                <?php if($pagination->current > 1): ?>
                    <li><a href='?page=<?php echo $pagination->prev ?>'>Previous</a></li>
                <?php else: ?>
                    <li class="disabled"><a href="#" >Previous</a></li>
                <?php endif ?>

                <?php for($i = 1; $i <= $pages; $i++): ?>
                    <?php if($i == $page): ?>
                        <li class="disabled"><a href="#" ><?php echo $i ?></a></li>
                    <?php else: ?>
                        <li><a href='?page=<?php echo $i ?>'><?php echo $i ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if(!$pagination->is_last_page): ?>
                    <li><a href='?page=<?php echo $pagination->next ?>'>Next</a></li>
                <?php else: ?>
                    <li class="disabled"><a href="#" >Next</a></li>
                <?php endif ?>
            <?php endif ?>
        </ul>
    </div>

    <br/><br/>
    <a class="btn btn-large btn-primary span3 middle" href="<?php encode_quotes(url('thread/create')) ?>">Create</a>
    <br/><br/>
</div>