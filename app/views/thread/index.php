<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <h1 class="title">Threads</h1>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
        <?php if(empty($threads)): ?>
            <div class="panel panel-primary">
                <div class="panel-body">
                    No available threads. ☹☹☹
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
        <?php foreach($threads as $v): ?>
            <div class="panel panel-primary" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>'" style="cursor:pointer;">
                <div class="panel-heading">
                    <p class="smallsize"> <?php echo "{$v->user_id}"?></p>
                    <p class="smallersize"><?php echo readable_text(date("l, F d, Y h:i a", strtotime($v->created))); ?></p>
                </div>
                <div class="panel-body">
                    <p><?php encode_quotes($v->title) ?> </p>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
        <div class="well">
            <?php if($pages > 1): ?>
                <ul class="pagination pagination-centerted">
                        <?php if($pagination->current > 1): ?>
                            <li><a href='?page=<?php echo $pagination->prev ?>'>Previous</a></li>
                        <?php else: ?>
                            <li class="disabled"><a href="#" >Previous</a></li>
                        <?php endif ?>

                        <?php for($i = 1; $i <= $pages; $i++): ?>
                            <?php if($i == $page): ?>
                                <li class="active"><a href="#" ><?php echo $i ?></a></li>
                            <?php else: ?>
                                <li><a href='?page=<?php echo $i ?>'><?php echo $i ?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if(!$pagination->is_last_page): ?>
                            <li><a href='?page=<?php echo $pagination->next ?>'>Next</a></li>
                        <?php else: ?>
                            <li class="disabled"><a href="#" >Next</a></li>
                        <?php endif ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <a class="btn btn-lg btn-primary" href="<?php encode_quotes(url('thread/create')) ?>">Create</a>
    </div>
</div>