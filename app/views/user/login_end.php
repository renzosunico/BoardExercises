<div class="hero-unit">
    <h1><?php echo get_welcome_message() . " {$_SESSION['username']}!"?></h1>
    <p>You have successfully signed in to your account.</p>
    <p>
        <a class="btn btn-primary btn-large" href="<?php encode_quotes(url('thread/index')) ?>">
            View threads
        </a>
    </p>
</div>