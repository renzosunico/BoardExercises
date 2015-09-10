<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="thread-title"><?php encode_quotes($thread->title) ?></h1>
    </div>
</div>

<?php 
    if(isset($_SESSION['old_comment'])) {
        $old_comment = new Comment($_SESSION['old_comment']);
    }
?>
<?php if(isset($old_comment) && $old_comment->hasError()): ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="alert alert-danger">
            <h4 class="alert-heading">
                <span class="glyphicon glyphicon-warning-sign"></span> Warning!
            </h4>
            <?php if(!empty($old_comment->validation_errors['body']['length'])): ?>
                <div><em>Comment</em> must be between
                    <?php encode_quotes($old_comment->validation['body']['length'][1]) ?> and
                    <?php encode_quotes($old_comment->validation['body']['length'][2]) ?> characters in length.
                </div>
            <?php endif ?>
            <?php if(!empty($old_comment->validation_errors['body']['chars'])): ?>
                <div><em>Comment</em> cannot be spaces only.
                </div>
            <?php endif ?>
        </div>
      </div>
    </div>
<?php endif; unset($_SESSION['old_comment']); ?>



<?php
    if(isset($_SESSION['delete_error'])): 
        unset($_SESSION['delete_error']); ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-danger">
                <h4 class="alert-heading">Warning!</h4>
                <?php if(!empty($old_comment->validation_errors['body']['length'])): ?>
                    <div>
                        Failed to delete comment. Please try again later.
                    </div>
                <?php endif ?>
            </div>
          </div>
        </div>
<?php endif ?>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="well well-large">
            <div class="row">
                <div class="col-xs-2 text-left">
                    <a href="<?php encode_quotes(url('thread/index')) ?>" class="btn btn-default">Back to Threads</a>
                </div>
                <div class="col-xs-offset-4 col-xs-6 text-right">
                    <form action="<?php encode_quotes(url('comment/view')) ?>" class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-user" id="basic-addon1"></span>
                                <input type="text" name="username" value="<?php encode_quotes($filter_username) ?>" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <input type="hidden" name="thread_id" value="<?php encode_quotes($thread->id) ?>">
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-filter"></span>  Filter</button>
                        <?php if(!empty($filter_username)): ?>
                            <div class="form-group">
                                <a class="btn btn-default" href="<?php encode_quotes(url('comment/view', array('thread_id' => $thread->id))) ?>">
                                    <span class="glyphicon glyphicon-scissors"></span> Unfilter
                                </a>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <div class="dropdown">
                              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="glyphicon glyphicon-th-list"></span> Sort By 
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="<?php encode_quotes(url('comment/view', array('sort' => "comment", 'thread_id' => $thread->id))) ?>"> <span class="glyphicon glyphicon-sort-by-order-alt"></span> Comment</a></li>
                              </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(empty($comments)): ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="well well-large">
                <?php if(!empty($filter_username)): ?>
                    <h4> No comments by <?php encode_quotes($filter_username) ?>. </h4>
                <?php else: ?>
                    <h4> No comments yet in this thread... <small>Start conversation!</small></h4>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php endif ?>

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
                        <?php if($comment->likecount <= 1): ?>
                            <label class="btn btn-primary btn-xs likes">
                                <span class="glyphicon glyphicon-hand-right"> <?php encode_quotes("$comment->likecount") ?> person</span> 
                            </label>
                        <?php else: ?>
                            <label class="btn btn-primary btn-xs likes">
                                <span class="glyphicon glyphicon-hand-right"> <?php encode_quotes("$comment->likecount") ?> people</span>
                            </label>
                        <?php endif ?>

                        <?php if(!$comment->is_liked): ?>
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
                        <?php if($comment->is_author): ?>
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
<div class="row">
    <div class="colxs-12 col-sm-12 col-md-12 col-lg-12">
        <?if ($pages > 1): ?>
            <div class="well well-large">
                <nav>
                    <ul class="pagination">
                        <?php if($pagination->current > 1): ?>
                            <li><a href="?thread_id=<?php echo $thread->id ?>
                            &page=<?php echo $pagination->prev ?>">Previous</a></li>
                        <?php else: ?>
                            <li class="disabled"><a href="#">Previous</a></li>
                        <?php endif ?>

                        <?php for($i=1; $i<=$pages; $i++): ?>
                            <?php if($i == $page): ?>
                                <li class="active"><a href="#"><?php echo $i ?></a></li>
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
                    </ul>
                </nav>
            </div>
        <?php endif ?>
    </div>
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
