<?php
define('APP_PATH',realpath(dirname(__FILE__)));
define('DS',DIRECTORY_SEPARATOR);
//define('ENVIROMENT','development');
define('ENVIROMENT','production');
require_once 'bootstrap.php';
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors',true);

$dispatch = new Dispatch($_GET['url']);
$dispatch->load();



