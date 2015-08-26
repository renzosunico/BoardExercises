<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo "UpThread ", isset($thread->title) ? " | {$thread->title}" : "" ?></title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/customized.css" rel="stylesheet">
    <style>
      body {
        background:url("/bootstrap/img/bg1.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        padding-top: 60px;
      }
    </style>
  </head>

  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="<?php echo isset($_SESSION['username']) ? encode_quotes(url('thread/index')) : "" ?>">UpThread</a>

          <ul class="nav pull-right">
            <?php if(isset($page) && (!preg_match('/(registration)|^(login)$/',$page))): ?>
              <li> <a href="<?php echo isset($_SESSION['username']) ? encode_quotes(url('thread/index')) : "" ?>">Home</a>
              <?php redirect_to_login() ?>
            <?php endif ?>
            
            <?php if(isset($page) && preg_match('/^login$/', $page)): ?>
              <li><a href="<?php echo(url('user/registration')) ?>">Sign up</a></li>
            <?php endif ?>

            <?php if(isset($_SESSION['username'])): ?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo isset($_SESSION['username']) ? "{$_SESSION['username']}" : "" ?>
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Edit profile</a></li>
                  <li><a href="<?php encode_quotes(url('user/logout')) ?>">Logout</a></li> 
                </ul>
              </li>
            <?php endif ?>
        </ul>

        </div>
      </div>
    </div>

    <div class="container">
      <?php echo $_content_ ?>
    </div>
    <script>
    console.log(<?php encode_quotes(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>
    <script src="/bootstrap/js/jquery-2.1.4.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
  </body>
  
</html>