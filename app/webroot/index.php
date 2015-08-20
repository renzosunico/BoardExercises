<?php
define('ROOT_DIR', dirname(dirname(__DIR__)).'/');
define('APP_DIR', ROOT_DIR.'app/');
require_once ROOT_DIR.'dietcake/dietcake.php';
require_once CONFIG_DIR.'bootstrap.php';
require_once CONFIG_DIR.'core.php';
try {
Dispatcher::invoke();
} catch (DCException $e) {
	header('HTTP/1.0 404 Not Found'); ?>
	<style> .center{display:block;margin-left:auto;margin-right:auto;}</style>
	<a href="/user/registration"><img class="center"align="center" src="/bootstrap/img/notfound.jpg" alt="notfound"></a>
<?php }