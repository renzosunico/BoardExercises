<br><br>
<div class="container">
<h1 class="white" align="center">Login</h1>
</div>
<br>

<?php if($isAuthorized === false): ?>
<div class="alert alert-error" align="center">
	<b>Invalid username and password.</b>
</div>

<?php endif ?>
<form class="well well-fit container" method="post" action="<?php eh(url('')) ?>">
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo readable_text(Param::get('username')) ?>">
		<label>Password:</label>
		<input type="password" name="password" value="<?php echo readable_text(Param::get('password')) ?>">
		<br/>
		<input type="hidden" name="page_next" value="login_end">
		<button type="submit" class="btn btn-primary btn-large span3 offsetop">Login</button>
		<br/><br/><br/>
</form>