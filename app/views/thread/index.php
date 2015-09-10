<?php 
    if(isset($_SESSION['old_thread'])) {
        $old_thread = new Thread($_SESSION['old_thread']); 
    }
    if(isset($_SESSION['old_comment'])) {
        $old_comment = new Comment($_SESSION['old_comment']);
    }
?>

<?php if((isset($old_thread) && $old_thread->hasError()) || (isset($old_comment) && $old_comment->hasError())): ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="alert alert-danger">
            <h4 class="alert-heading">Validation Error!</h4>
            <?php if (!empty($old_thread->validation_errors['title']['length'])): ?>
                <div><em>Title</em> must be between
                    <?php encode_quotes($old_thread->validation['title']['length'][1]) ?> and
                    <?php encode_quotes($old_thread->validation['title']['length'][2]) ?> characters in length.
                </div>
            <?php endif ?>
            <?php if(!empty($old_thread->validation_errors['title']['chars'])): ?>
                <div><em>Title</em> cannot be spaces only.
                </div>
            <?php endif ?>
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
            <?php if(!empty($old_thread->validation_errors['category']['content'])): ?>
                <div>
                    <em>Category</em> is required.
                </div>
            <?php endif ?>
        </div>
      </div>
    </div>
<?php endif; unset($_SESSION['old_thread']); unset($_SESSION['old_comment']); ?>

<?php if(array_key_exists('deleteHasError', $_SESSION)): ?>
<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
        <div class="alert alert-danger">
            <strong>Delete</strong> was unsuccessful.
        </div>
    </div>
</div>
<?php endif;
      unset($_SESSION['deleteHasError'])?>

<div class="row">
    <div class="col-xs-12  col-md-6 col-lg-7">
        <div class="well well-small">
            <div class="row">
                <div class="col-xs-6">
                    <a class="btn btn-primary" href="<?php echo url('thread/create') ?>"><span class="glyphicon glyphicon-pencil"></span>
                    Create Thread</a>
                </div>
                <div class="col-xs-offset-3 col-xs-3 col-sm-offset-3 col-sm-3 col-md-offset-3 col-md-3 col-lg-offset-3 col-lg-3">
                    <div class="dropdown pull-right">
                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="glyphicon glyphicon-th-list"></span> Sort By 
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="<?php encode_quotes(url('thread/index', array('sort' => "category_name"))) ?>">Category</a></li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php if(empty($threads)): ?>
            <div class="panel panel-primary">
                <div class="panel-body">
                    No available threads. ☹☹☹
                </div>
            </div>
        <?php endif ?>
        <?php foreach($threads as $thread): ?>
            <div class="panel panel-primary">

                <div class="panel-heading" onclick="location.href='<?php encode_quotes(url('user/profile', array('user_id' => $thread->user_id))) ?>'" style="cursor:pointer;">
                    <p class="smallsize"> <?php echo "{$thread->username}"?></p>
                    <?php print_date($thread) ?>
                </div>

                <div class="showfooter panel-body" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $thread->id))) ?>'" style="cursor:pointer;">
                    <p><?php encode_quotes($thread->title) ?> </p>
                </div>
                <div class="panel-footer">
                    <span class="tag label label-default"><span class="glyphicon glyphicon-tag"></span> <?php encode_quotes($thread->category_name) ?></span>
                    <?php if($thread->isAuthor()): ?>
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit<?php encode_quotes($thread->id) ?>"><span class="glyphicon glyphicon-font" > </span> Edit</button>
                        <div class="modal" id="edit<?php encode_quotes($thread->id) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Edit Thread</h4>
                              </div>
                              <div class="modal-body">
                                <form action="<?php echo url('thread/edit') ?>" method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="title" class="col-sm-1 control-label">Title: </label>
                                        <div class="col-sm-offset-1 col-sm-4">
                                            <input name="title" type="text" class="form-control" id="title" value="<?php encode_quotes($thread->title) ?>" placeholder="Title">
                                        </div>
                                        <label for"category" class="col-sm-1 control-label">Category:</label>
                                        <div class="col-sm-offset-1 col-sm-4">
                                            <select class="form-control" id="category" name="category">
                                                <option></option>
                                                <option <?php echo ($thread->category_name == 'Android')         ? 'selected' : '' ?> >Android</option>
                                                <option <?php echo ($thread->category_name == 'iOS')             ? 'selected' : '' ?> >iOS</option>
                                                <option <?php echo ($thread->category_name == 'PHP')             ? 'selected' : '' ?> >PHP</option>
                                                <option <?php echo ($thread->category_name == 'Unity')           ? 'selected' : '' ?> >Unity</option>
                                                <option <?php echo ($thread->category_name == 'Graphics 2D&3D')  ? 'selected' : '' ?> >Graphics 2D&amp;3D</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="body" class="col-sm-1">Comment: </label>
                                        <div class="col-sm-offset-1 col-sm-10">
                                            <textarea name="body" id="body" class="form-control"><?php encode_quotes($thread->comment['body']) ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        <input type="hidden" name="thread_id" value="<?php encode_quotes($thread->id) ?>">
                                    </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    <!--End of Editing Thread-->
                    <!-- Delete -->
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete<?php encode_quotes($thread->id) ?>">
                      <span class="glyphicon glyphicon-trash"></span>
                      Delete
                    </button>

                    <div class="modal" id="delete<?php encode_quotes($thread->id) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Warning</h4>
                          </div>
                          <div class="modal-body">
                            Do you really want to delete this thread?
                            <br/><br/>
                          <div class="modal-footer">
                            <input type="hidden" name="page_next" value="delete_end">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-danger" href="<?php encode_quotes(url('thread/delete', array('thread_id' => $thread->id))) ?>">Delete</a>
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php endif ?>

                    <?php if(!$thread->isAuthor()): ?>
                        <?php if(!Follow::isFollowed($thread->id)): ?>
                            <a href="<?php encode_quotes(url('thread/follow', array('thread_id' => $thread->id, 'process' => "follow"))) ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-bookmark"></span> Follow</a>
                        <?php else: ?>
                            <a href="<?php encode_quotes(url('thread/follow', array('thread_id' => $thread->id, 'process' => "unfollow"))) ?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-minus-sign"></span> Unfollow</a>
                        <?php endif ?>
                    <?php endif ?>
                    
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="col-xs-12  col-md-6 col-lg-5">
        <div class="well well-large">
            <div class="page-header">
              <h1><small>Trending Threads</small></h1>
            </div>
            <?php foreach ($trending_threads as $thread): ?>
                <ul class="list-group">
                  <li class="list-group-item" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $thread['thread_id']))) ?>'" style="cursor:pointer;">
                    <span class="badge"><?php encode_quotes($thread['count']) ?></span>
                    <?php echo $thread['title'] ?>
                  </li>
                </ul>
            <?php endforeach ?>
        </div>
    </div>
</div>

<?php if($pages > 1): ?>
    <div class="row">
        <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
            <div class="well">
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
            </div>
        </div>
    </div>
<?php endif ?>