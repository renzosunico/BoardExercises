<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
        <div class="well well-small">
            <a class="btn btn-primary" href="<?php echo url('thread/create') ?>"><span class="glyphicon glyphicon-pencil"></span>
        Create Thread</a>
        </div>
    </div>
</div>

<?php if(array_key_exists('editHasError', $_SESSION)): ?>
<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
        <div class="alert alert-danger">
            <strong>Edit</strong> was uncessful.
        </div>
    </div>
</div>
<?php endif;
      unset($_SESSION['editHasError'])?>

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

<?php foreach($threads as $thread): ?>
    <div class="row">
        <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <p class="smallsize"> <?php echo "{$thread->user_id}"?></p>
                    <p class="smallersize"><?php echo readable_text(date("l, F d, Y h:i a", strtotime($thread->created))); ?></p>
                </div>
                <div class="panel-body" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $thread->id))) ?>'" style="cursor:pointer;">
                    <p><?php encode_quotes($thread->title) ?> </p>
                </div>
                <div id="footer" class="panel-footer">
                    <?php if($thread->user_id === $_SESSION['username']): ?>
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit<?php encode_quotes($thread->id) ?>"><span class="glyphicon glyphicon-font"></span></button>
                        <div class="modal fade" id="edit<?php encode_quotes($thread->id) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                            <textarea name="body" id="body" class="form-control"><?php get_thread_comment($thread->id) ?></textarea>
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
                    </button>

                    <div class="modal fade" id="delete<?php encode_quotes($thread->id) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

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