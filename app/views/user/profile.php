<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-8 col-lg-offset-0 col-lg-8">
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
    <div class="col-xs-12 col-md-offset-0 col-md-8 col-lg-offset-0 col-lg-8">
      <div class="well well-large">
        <div class="page-header">
          <?php if($user->isUser()): ?>
              <h1>Threads<small> you are following:</small></h1>
          <?php else: ?>
              <h1>Threads<small> <?php encode_quotes($user->fname) ?> is following:</small></h1>
          <?php endif ?>
        </div>
        <?php if($user->isUser() && $user->hasThreadFollowed()): ?>
          <h4>You are not following any threads. </h1>
        <?php else: ?>
          <h4><?php encode_quotes($user->fname) ?> is not following any threads.</h4>
        <?php endif ?>
        
        <?php foreach($threads_followed as $thread): ?>
          <div class="row showfooter">
            <div class="col-xs-12 col-md-offset-0 col-md-12 col-lg-offset-0 col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <p class="smallsize"> <?php echo "{$thread->user_id}"?></p>
                        <p class="smallersize"><?php echo readable_text(date("l, F d, Y h:i a", strtotime($thread->created))); ?></p>
                    </div>
                    <div class="panel-body" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $thread->id))) ?>'" style="cursor:pointer;">
                        <p><?php encode_quotes($thread->title) ?> </p>
                    </div>
                    <div class="panel-footer">
                        <label class="tag"><span class="glyphicon glyphicon-tag"></span> <?php encode_quotes($thread->category_name) ?></label>
                          <?php if(!$thread->isAuthor()): ?>
                            <?php if(!$thread->isFollowed()): ?>
                                <a href="<?php encode_quotes(url('thread/follow', array('thread_id' => $thread->id, 'process' => "follow", 'page' => "user/profile", 'user_id' => "$user->id"))) ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-bookmark"></span> Follow</a>
                            <?php else: ?>
                                <a href="<?php encode_quotes(url('thread/follow', array('thread_id' => $thread->id, 'process' => "unfollow", 'page' => "user/profile", 'user_id' => "$user->id"))) ?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-minus-sign"></span> Unfollow</a>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
          </div>
        <?php endforeach ?>

      </div>
    </div>
</div>