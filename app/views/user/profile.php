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
      <div class="col-xs-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8s">
        <div class="alert alert-danger">
            <h4 class="alert-heading">Validation Error!</h4>
            <?php if (!empty($old_thread->validation_errors['title']['length'])): ?>
                <div><em>Title</em> must be between
                    <?php encode_quotes($old_thread->validation['title']['length'][1]) ?> and
                    <?php encode_quotes($old_thread->validation['title']['length'][2]) ?> characters in length.
                </div>
            <?php endif ?>
            <?php if(!empty($old_comment->validation_errors['body']['length'])): ?>
                <div><em>Comment</em> must be between
                    <?php encode_quotes($old_comment->validation['body']['length'][1]) ?> and
                    <?php encode_quotes($old_comment->validation['body']['length'][2]) ?> characters in length.
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

<div class="row">
    <div class="col-xs-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
        <div class="well well-large">
            <div class="row">
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                    <a href="#" class="thumbnail">
                      <img src="..." alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-sm-8 col-md-9 col-lg-9">
                    <form action="" class="form-horizontal">
                      <div id="nomnop" class="form-group">
                        <label id="nobottommargin" class="col-sm-3 col-md-3 col-lg-3 control-label">Name:</label>
                        <div class="col-sm-9 col-md-9 col-lg-9">
                          <p class="form-control-static"><?php encode_quotes("$user->fname" . " " . "$user->lname"); ?></p>
                        </div>
                      </div>
                      <div id="nomnop" class="form-group">
                        <label id="nobottommargin" class="col-sm-3 col-md-3 col-lg-3 control-label">Username:</label>
                        <div class="col-sm-9 col-md-9 col-lg-9">
                          <p class="form-control-static"><?php encode_quotes("$user->username"); ?></p>
                        </div>
                      </div>
                      <?php if(isset($user->company)): ?>
                      <div id="nomnop" class="form-group">
                        <label id="nobottommargin" class="col-sm-3 col-md-3 col-lg-3 control-label">Company:</label>
                        <div class="col-sm-9 col-md-9 col-lg-9">
                          <p class="form-control-static"><?php encode_quotes("$user->company"); ?></p>
                        </div>
                      </div>
                      <?php endif ?>
                      <?php if(isset($user->division)): ?>
                      <div id="nomnop" class="form-group">
                        <label id="nobottommargin" class="col-sm-3 col-md-3 col-lg-3 control-label">Division:</label>
                        <div class="col-sm-9 col-md-9 col-lg-9">
                          <p class="form-control-static"><?php encode_quotes("$user->division"); ?></p>
                        </div>
                      </div>
                      <?php endif ?>
                      <?php if(isset($user->specialization)): ?>
                      <div id="nomnop" class="form-group">
                        <label id="nobottommargin" class="col-sm-3 col-md-3 col-lg-3 control-label">Specialization:</label>
                        <div class="col-sm-9  col-md-9 col-lg-9">
                          <p class="form-control-static"><?php encode_quotes("$user->specialization"); ?></p>
                        </div>
                      </div>
                      <?php endif ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
      <div class="well well-large">
        <div class="page-header">
          <?php if($user->isUser()): ?>
              <h1>Threads<small> you are following:</small></h1>
          <?php else: ?>
              <h1>Threads<small> <?php encode_quotes($user->fname) ?> is following:</small></h1>
          <?php endif ?>
        </div>
        <?php if($user->isUser() && !$user->hasThreadFollowed()): ?>
          <h4>You are not following any threads. </h1>
        <?php elseif(!$user->isUser() && !$user->hasThreadFollowed()): ?>
          <h4><?php encode_quotes($user->fname) ?> is not following any threads.</h4>
        <?php endif ?>
      </div>
      <?php foreach($threads_followed as $thread): ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <p class="smallsize"> <?php echo "{$thread->username}"?></p>
                <p class="smallersize"><?php echo readable_text(date("l, F d, Y h:i a", strtotime($thread->created))); ?></p>
            </div>
            <div class="panel-body showfooter" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $thread->id))) ?>'" style="cursor:pointer;">
                <p><?php encode_quotes($thread->title) ?> </p>
            </div>
            <div class="panel-footer">
                <label class="tag"><span class="glyphicon glyphicon-tag"></span> <?php encode_quotes($thread->category_name) ?></label>
                  <?php if(!$thread->isAuthor()): ?>
                    <?php if(!Follow::isFollowed($thread->id)): ?>
                        <a href="<?php encode_quotes(url('thread/follow', array('thread_id' => $thread->id, 'process' => "follow", 'page' => "user/profile", 'user_id' => "$user->id"))) ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-bookmark"></span> Follow</a>
                    <?php else: ?>
                        <a href="<?php encode_quotes(url('thread/follow', array('thread_id' => $thread->id, 'process' => "unfollow", 'page' => "user/profile", 'user_id' => "$user->id"))) ?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-minus-sign"></span> Unfollow</a>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
      <?php endforeach ?>
    </div>
</div>

<div class="row">
  <div class="col-xs-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
    <div class="well well-large">
      <div class="page-header">
        <?php if($user->isUser()): ?>
          <h1>Threads<small> you created:</small></h1>
        <?php else: ?>
          <h1>Threads<small> <?php encode_quotes($user->fname) ?> has created:</small></h1>
        <?php endif ?>
      </div>
      <?php if($user->isUser() && !Thread::hasThread($user->id)): ?>
        <h4>You do not have any threads. </h4>
      <?php elseif(!$user->isUser() && !Thread::hasThread($user->id)): ?>
        <h4><?php encode_quotes($user->fname) ?> has no threads yet. </h4>
      <?php endif ?>
    </div>
    
      <?php foreach($threads_created as $thread): ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <p class="smallsize"> <?php echo "{$thread->username}"?></p>
                <p class="smallersize"><?php echo readable_text(date("l, F d, Y h:i a", strtotime($thread->created))); ?></p>
            </div>
            <div class="panel-body showfooter" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $thread->id))) ?>'" style="cursor:pointer;">
                <p><?php encode_quotes($thread->title) ?> </p>
            </div>
            <div class="panel-footer">
                <label class="tag"><span class="glyphicon glyphicon-tag"></span> <?php encode_quotes($thread->category_name) ?></label>
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
                                        <textarea name="body" id="body" class="form-control"><?php get_thread_comment($thread->id) ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    <input type="hidden" name="thread_id" value="<?php encode_quotes($thread->id) ?>">
                                    <input type="hidden" name="page" value="profile">
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
                        <a class="btn btn-danger" href="<?php encode_quotes(url('thread/delete', array('thread_id' => $thread->id, 'page' => 'profile'))) ?>">Delete</a>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    <?php endforeach ?>
  </div>
</div>