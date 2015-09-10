    <div class="row">
        <div class="col-xs-offset-1 col-xs-10 col-md-offset-0 col-md-5 col-lg-offset-0 col-lg-4">
            <h1><font color="white" style="font-family: 'Fjalla One', sans-serif;"> Create an account </font></h1>
        </div>
    </div>
<?php if($user->hasError()): ?>
    <div class="row">
        <div class="custom-text-center alert alert-danger col-xs-offset-1 col-xs-10 col-md-offset-0 col-md-5 col-lg-offset-0 col-lg-4" role="alert">
            <h4><b>Warning</b></h4>
                <?php if(!empty($user->validation_errors['fname']['length'])): ?>   
                    <div><em>First name</em> must be at least 
                    <?php encode_quotes($user->validation['fname']['length'][1]) ?> to
                    <?php encode_quotes($user->validation['fname']['length'][2]) ?> characters in length.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['fname']['alphachars'])): ?>   
                    <div><em>First name</em> must contain letters or space only.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['lname']['length'])): ?>   
                    <div><em>Last name</em> must be at least
                    <?php encode_quotes($user->validation['lname']['length'][1]) ?> to
                    <?php encode_quotes($user->validation['lname']['length'][2]) ?> characters in length.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['lname']['alphachars'])): ?>   
                    <div><em>Last name</em> must contain letters or space only. 
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['username']['length'])): ?>    
                    <div><em>Username</em> must be at least
                    <?php encode_quotes($user->validation['username']['length'][1]) ?> to
                    <?php encode_quotes($user->validation['username']['length'][2]) ?> characters in length.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['username']['chars'])): ?> 
                    <div><em>Username</em> must contain alphanumeric characters only. 
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['username']['exist'])): ?> 
                    <div><em>Username</em> already exists. 
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['password']['length'])): ?>    
                    <div><em>Password</em> must be at least
                    <?php encode_quotes($user->validation['password']['length'][1]) ?> to
                    <?php encode_quotes($user->validation['password']['length'][2]) ?> characters in length.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['password']['chars'])): ?> 
                    <div><em>Your password</em> must contain alphanumeric characters only. 
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['confirmpassword']['confirm'])): ?> 
                    <div><em>Your password</em> did not matched. 
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['email']['email'])): ?>    
                    <div><em>Your email</em> must be in valid email format. 
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['email']['exist'])): ?>    
                    <div><em>Email address</em> is already associated with other user. 
                    </div>
                <?php endif ?>
        </div>
    </div>
<?php endif ?>

    <div class="row">
        <form class="well well-large col-xs-offset-1 col-xs-10 col-md-offset-0 col-md-5 col-lg-offset-0 col-lg-4" autocomplete="off" method="post" action="<?php encode_quotes(url('')) ?>">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" name="fname" class="form-control" id="firstname" value="<?php encode_quotes(isset($user->username) ? "$user->fname" : "") ?>" placeholder="First Name">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" name="lname" class="form-control" id="firstname" value="<?php encode_quotes(isset($user->username) ? "$user->lname" : "") ?>" placeholder="Last Name">
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" id="username" value="<?php encode_quotes(isset($user->username) ? "$user->username" : "") ?>" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php encode_quotes(isset($user->email) ? "$user->email" : "") ?>" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="repassword">Confirm Password:</label>
                <input type="password" name="repassword" class="form-control" id="repassword" placeholder="Confirm Password">
            </div>
            <input type="hidden" name="page_next" value="registration_end">
            <button type="submit" class="btn btn-primary btn-block ">Sign up </button>
            <br/>
            <p align="center" class="span3 offset-left">
            <br/>
            Already have an account?
            <br/>
            <a href="<?php encode_quotes(url('user/login')) ?>"> Login here </a>
            </p>
            <br/><br/><br/>
        </form>
    </div>
