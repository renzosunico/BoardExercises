<style type="text/css">
	.color-white {color: white;}
	.center {margin:auto;width:25%;padding:inherit;color:transparent;}
</style>

<br><br>
<h1 class="color-white">Login</h1>
<br>

<?php if($isAuthorized === false): ?>
<div class="alert alert-error" align="center">
	<b>Invalid username and password.</b>
</div>

<?php endif ?>
<form class="well large" method="post" action="<?php eh(url('')) ?>">
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo Param::get('username') ?>">
		<label>Password:</label>
		<input type="password" name="password" value="<?php echo Param::get('password') ?>">
		<br/>
		<input type="hidden" name="page_next" value="login_end">
		<button type="submit" class="btn btn-primary btn-large span3 offsetop">Login</button>
		<br/><br/><br/>
</form>