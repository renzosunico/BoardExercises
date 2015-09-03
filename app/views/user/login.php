<div class="row">
    <div class="col-xs-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
        <h1><font color="white" style="font-family: 'Fjalla One', sans-serif;">Login</font></h1>
    </div>
</div>
<br/>

<?php if(isset($isAuthorized) && $isAuthorized === false): ?>
    <div class="row">
        <div class="col-xs-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
          <div class="alert alert-danger">
            Your username or password might be incorrect.
          </div>  
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
            <div class="form-group has-error">
                <form class="well well-large form-horizontal" method="post" action="<?php encode_quotes(url('')) ?>">
                  <br/>
                  <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                  </div>
                  <input type="hidden" name="page_next" value="login_end">
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-xs-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
            <div class="control-group">
                <form class="well well-large form-horizontal" method="post" action="<?php encode_quotes(url('')) ?>">
                  <br/>
                  <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                  </div>
                  <input type="hidden" name="page_next" value="login_end">
                </form>
            </div>
        </div>
    </div>
<?php endif ?>