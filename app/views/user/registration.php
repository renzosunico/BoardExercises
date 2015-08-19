<br/><br/>

<h1><font color="white"> Create an account </font></h1>

<br/>
<?php if($user->hasError()): ?>
	<div class="alert alert-error">
		<h4><b>Validation Error!</b></h4>
			<?php if(!empty($user->validation_errors['fname']['length'])): ?>	
				<div><em>Your name</em> must be between
				<?php eh($user->validation['fname']['length'][1]) ?> and
				<?php eh($user->validation['fname']['length'][2]) ?> characters in length.
				</div>
			<?php endif ?>

			<?php if(!empty($user->validation_errors['fname']['alphachars'])): ?>	
				<div><em>Your name</em> must contain alphabetic characters only.
				</div>
			<?php endif ?>

			<?php if(!empty($user->validation_errors['lname']['length'])): ?>	
				<div><em>Your last name</em> must be between
				<?php eh($user->validation['lname']['length'][1]) ?> and
				<?php eh($user->validation['lname']['length'][2]) ?> characters in length.
				</div>
			<?php endif ?>

			<?php if(!empty($user->validation_errors['lname']['alphachars'])): ?>	
				<div><em>Your last name</em> must contain alphabetic characters only. 
				</div>
			<?php endif ?>

			<?php if(!empty($user->validation_errors['username']['length'])): ?>	
				<div><em>Your username</em> must be between
				<?php eh($user->validation['username']['length'][1]) ?> and
				<?php eh($user->validation['username']['length'][2]) ?> characters in length.
				</div>
			<?php endif ?>

			<?php if(!empty($user->validation_errors['username']['chars'])): ?>	
				<div><em>Your username</em> must contain alphanumeric characters only. 
				</div>
			<?php endif ?>

			<?php if(!empty($user->validation_errors['username']['exist'])): ?>	
				<div><em>Username</em> already exists. 
				</div>
			<?php endif ?>

			<?php if(!empty($user->validation_errors['password']['length'])): ?>	
				<div><em>Your password</em> must be between
				<?php eh($user->validation['password']['length'][1]) ?> and
				<?php eh($user->validation['password']['length'][2]) ?> characters in length.
				</div>
			<?php endif ?>

			<?php if(!empty($user->validation_errors['password']['chars'])): ?>	
				<div><em>Your password</em> must contain alphanumeric characters only. 
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
<?php endif ?>

	<form class="well large" method="post" action="<?php eh(url('')) ?>">
		<label>Name:</label>
		<input type="text" class="span3" name="fname">
		<label>Last Name:</label>
		<input type="text" class="span3" name="lname">
		<label>Username:</label>
		<input type="text" class="span3" name="username">
		<label>Your Email:</label>
		<input type="text" class="span3" name="email">
		<label>Password:</label>
		<input type="password" class="span3" name="password">
		<input type="hidden" name="page_next" value="registration_end">
	</br>
		<button type="submit" class="btn btn-primary btn-large span3 offset-1">Sign up </button>
		<br><br>
		<p align="center" class="span3 offset-1">
		Already have an account? <br/>
		<a href="<?php eh(url('user/login')) ?>"> Login here </a>
		</p>
		<br/><br/><br/>
	</form>