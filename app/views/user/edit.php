<div class="row">
    <div class="col-xs-12">
        <?php if($user->hasError() || isset($user->notAuthorized)): ?>
            <div class="alert alert-danger" role="alert">
                <h4><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <b>Warning</b>
                </h4>

                <?php if(isset($user->notAuthorized)): ?>
                        Incorrect Password
                <?php endif; unset($user->notAuthorized) ?>

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

                <?php if(!empty($user->validation_errors['new_username']['exist'])): ?> 
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

                <?php if(!empty($user->validation_errors['new_email']['exist'])): ?>    
                    <div><em>Email address</em> is already associated with other user. 
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['company']['alphachars'])): ?>    
                    <div><em>Company</em> must contain letters or space only.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['company']['length'])): ?>    
                    <div><em>Company</em> must be at least
                    <?php encode_quotes($user->validation['company']['length'][1]) ?> to
                    <?php encode_quotes($user->validation['company']['length'][2]) ?> characters in length.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['division']['alphachars'])): ?>    
                    <div><em>Division</em> must contain letters or space only.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['division']['length'])): ?>    
                    <div><em>Division</em> must be at least
                    <?php encode_quotes($user->validation['division']['length'][1]) ?> to
                    <?php encode_quotes($user->validation['division']['length'][2]) ?> characters in length.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['specialization']['alphachars'])): ?>    
                    <div><em>Specialization</em> must contain letters or space only.
                    </div>
                <?php endif ?>

                <?php if(!empty($user->validation_errors['specialization']['length'])): ?>    
                    <div><em>Specialization</em> must be at least
                    <?php encode_quotes($user->validation['specialization']['length'][1]) ?> to
                    <?php encode_quotes($user->validation['specialization']['length'][2]) ?> characters in length.
                    </div>
                <?php endif ?>
            </div>
        <?php endif; unset($user->validation_errors) ?>
    </div>
</div>

<?php if(isset($user->editSuccess)): ?>
    <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span>
    Account has been updated!</div>
<?php endif; unset($user->editSuccess) ?>

<div class="row">
    <div class="col-xs-12">
        <div class="well well-large">
            <div class="page-header">
              <h1>Account Settings</h1>
            </div>
            <form method="post" action="<?php encode_quotes(url('user/edit')) ?>">
                <div class="form-group">
                    <label for="firstname">First Name: </label>
                    <input name="firstname" type="text" class="form-control" id="firstname" placeholder="First Name" value="<?php encode_quotes($user->fname) ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name: </label>
                    <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Last Name" value="<?php encode_quotes($user->lname) ?>">
                </div>
                <div class="form-group">
                    <label for="username">Username: </label>
                    <input name="username" type="text" class="form-control" id="username" placeholder="Username" value="<?php encode_quotes($user->username) ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="<?php encode_quotes($user->email) ?>">
                </div>
                <input type="hidden" name="process" value="account">
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="well well-large">
            <div class="page-header">
              <h1>Personal Information</h1>
            </div>
            <form method="post" action="<?php encode_quotes(url('user/edit')) ?>">
                <div class="form-group">
                    <label for="company">Company: </label>
                    <input name="company" type="text" class="form-control" id="company" placeholder="Company" value="<?php encode_quotes($user->company) ?>">
                </div>
                <div class="form-group">
                    <label for="division">Division: </label>
                    <input name="division" type="text" class="form-control" id="division" placeholder="Division" value="<?php encode_quotes($user->division) ?>">
                </div>
                <div class="form-group">
                    <label for="specialization">Specialization: </label>
                    <input name="specialization" type="text" class="form-control" id="specialization" placeholder="Specialization" value="<?php encode_quotes($user->specialization) ?>">
                </div>
                <input type="hidden" name="process" value="profile">
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="well well-large">
            <div class="page-header">
              <h1>Password</h1>
            </div>
            <form method="post" action="<?php encode_quotes(url('user/edit')) ?>">
                <div class="form-group">
                    <label for="old">Old Password: </label>
                    <input name="oldPassword" type="password" class="form-control" id="old" placeholder="Old Password">
                </div>
                <div class="form-group">
                    <label for="new">New Password: </label>
                    <input name="password" type="password" class="form-control" id="new" placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="confirm">Confirm Password: </label>
                    <input name="confirmPassword" type="password" class="form-control" id="confirm" placeholder="Confirm Password">
                </div>
                <input type="hidden" name="process" value="password">
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>

</div>