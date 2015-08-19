<style type="text/css">
	#colorid {color: white;}
	#center {margin:auto;width:25%;padding:inherit;color:transparent;}
</style>

<br><br>
<h1 id="colorid">Login</h1>
<br>

<?php if($isAuthorized === false): ?>
<div class="alert alert-error" align="center">
	<b>Invalid username and password.</b>
</div>
<?php endif ?>

<form id="colortrans" class="well large" method="post" action="<?php eh(url('')) ?>">
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo Param::get('username') ?>">
		<label>Password:</label>
		<input type="password" name="password" value="<?php echo Param::get('password') ?>">
		<br/>
		<input type="hidden" name="page_next" value="<?php eh(url('thread/index')) ?>">
		<button type="submit" class="btn btn-primary btn-large span3 offsetop">Login</button>
		<br/><br/><br/>
</form>