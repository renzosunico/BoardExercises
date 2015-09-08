<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="title"><?php encode_quotes($thread->title) ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php if(array_key_exists('hasError', $_SESSION) && $_SESSION['hasError']): ?>
        <div class="alert alert-danger">
            <h4 class="alert-heading">Validation error!</h4>
                <div><em>Comment</em> must be between
                <?php encode_quotes($comment->validation['body']['length'][1]) ?>
                and
                <?php encode_quotes($comment->validation['body']['length'][2]) ?>
                characters in length.
                </div>
            <?php unset($_SESSION['hasError']) ?>

        </div>
        <?php endif ?>
    </div>
</div>
<?php foreach($comments as $comment): ?>
<div class="row">
    <div class="colxs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <!--comment
                    <div class="col-xs-1">
                        
                    </div>
                    -->
                    <div class="col-xs-11">
                        <p class="smallsize"> <?php encode_quotes($comment->username)?></p>
                        <?php print_date($comment); ?>
                    </div>
                </div>
            </div>
            <div class="showfooter panel-body">
                <?php echo readable_text($comment->body) ?>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-xs-6">
                        <?php if(($like_count = Likes::countLike($comment->id)) <= 1): ?>
                            <label class="btn btn-primary btn-xs likes">
                                <span class="glyphicon glyphicon-hand-right"> <?php encode_quotes("$like_count") ?> person</span> 
                            </label>
                        <?php else: ?>
                            <label class="btn btn-primary btn-xs likes">
                                <span class="glyphicon glyphicon-hand-right"> <?php encode_quotes("$like_count") ?> people</span>
                            </label>
                        <?php endif ?>

                        <?php if(!Likes::isLiked($comment->id)): ?>
                            <a class="btn btn-default btn-xs btn-info" href="<?php encode_quotes(url('comment/like', array('thread_id' => $thread->id, 'comment_id' => $comment->id, 'process' => 'like'))) ?>">
                                <span class="glyphicon glyphicon-hand-right"></span> Like
                            </a>
                        <?php else: ?>
                            <a class="btn btn-default btn-xs btn-danger" href="<?php encode_quotes(url('comment/like', array('thread_id' => $thread->id, 'comment_id' => $comment->id, 'process' => 'unlike'))) ?>">
                                <span class="glyphicon glyphicon-thumbs-down"></span> Unlike
                            </a>
                        <?php endif ?>
                    </div>
                    <div class="col-xs-6 text-right">
                        <?php if($comment->isAuthor()): ?>
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit<?php encode_quotes($comment->id) ?>">
                              <span class="glyphicon glyphicon-font"></span> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete<?php encode_quotes($comment->id) ?>">
                              <span class="glyphicon glyphicon-trash"></span> Delete
                            </button>
                        <?php endif ?>
                    </div>
                    <!--Modals Edit-->
                    <div class="modal" id="edit<?php encode_quotes($comment->id) ?>" tabindex="-1" role="dialog" aria-labelledby="title<?php encode_quotes($comment->id) ?>">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="title<?php encode_quotes($comment->id) ?>">Edit Comment</h4>
                          </div>
                          <div class="modal-body">
                            <form metod="post" action="<?php encode_quotes(url('comment/edit')) ?>">
                                <div class="form-group">
                                    <label for="comment">Comment:</label>
                                    <textarea type="text" class="form-control" id="comment" name="body"><?php encode_quotes($comment->body); ?></textarea>
                                    <input type="hidden" name="thread_id" value="<?php encode_quotes($thread->id) ?>">
                                    <input type="hidden" name="comment_id" value="<?php encode_quotes($comment->id) ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Delete -->
                    <div class="modal" id="delete<?php encode_quotes($comment->id) ?>" tabindex="-1" role="dialog" aria-labelledby="title<?php encode_quotes($comment->id) ?>">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="title<?php encode_quotes($comment->id) ?>">Delete</h4>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to delete this comment ?
                              </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-danger" href="<?php encode_quotes(url('comment/delete', array('comment_id' => $comment->id, 'thread_id' => $thread->id))) ?>">Delete</a>
                            </div>
                            </div>
                          </div>
                    </div>
                    </div>

            </div>
        </div>
    </div>
</div>
<?php endforeach ?>
<div class="well">

<hr>

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
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea id="comment" name="body" class="form-control"><?php encode_quotes(Param::get('body')) ?></textarea>
    </div>
    <input type="hidden" name="thread_id" value="<?php encode_quotes($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Comment</button>
    </div>
</form>
