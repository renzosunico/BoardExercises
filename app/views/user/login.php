<br/><br/><br/><br/><br/><br/>
<div class="container">
<h1 class="white custom-text-center">Login</h1>
</div>
<br/>

<?php if($isAuthorized === false): ?>
    <div class="alert alert-error well container custom-well-fit">
        Your username or password might be incorrect.
    </div>
    <div class="control-group error">
        <form class="well container custom-well-fit" method="post" action="<?php encode_quotes(url('')) ?>">
            <label class="custom-red-font">Username:</label>
            <input type="text" id="inputError" name="username" value="<?php echo readable_text(Param::get('username')) ?>">
            <label class="custom-red-font">Password:</label>
            <input type="password" id="inputError" name="password" value="<?php echo readable_text(Param::get('password')) ?>">
            <br/>
            <input type="hidden" name="page_next" value="login_end">
            <button type="submit" class="btn btn-primary btn-large span3 offsetop">Login</button>
            <br/><br/><br/>
        </form>
    </div>
<?php else: ?>
    <form class="well container custom-well-fit " method="post" action="<?php encode_quotes(url('')) ?>">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo readable_text(Param::get('username')) ?>">
            <label>Password:</label>
            <input type="password" name="password" value="<?php echo readable_text(Param::get('password')) ?>">
            <br/>
            <input type="hidden" name="page_next" value="login_end">
            <button type="submit" class="btn btn-primary btn-large span3 offsetop">Login</button>
            <br/><br/><br/>
    </form>
<?php endif ?>