<?php
define('APP_PATH',realpath(dirname(__FILE__)));
define('DS',DIRECTORY_SEPARATOR);
require_once 'loader.php';

$order = new App_Crons_Order();
$order->verifyOrders();
