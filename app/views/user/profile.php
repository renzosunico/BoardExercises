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
