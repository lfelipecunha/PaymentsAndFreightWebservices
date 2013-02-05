<?php
define('APP_PATH',realpath(dirname(__FILE__)));
define('DS',DIRECTORY_SEPARATOR);
require_once 'bootstrap.php';
$cronName = @$argv[1];
if (empty($cronName)) {
    throw new Exception('Uma cron deve ser informada');
}
$cronName = 'App_Services_'.$cronName;
$cron = new $cronName();
if (!($cron instanceof App_Services_Abstract)) {
    throw new Exception('Invalid Cron');
}
while(true) {
    $resetFile = APP_PATH.DS.'tmp'.DS.'stop_'.strtolower($argv[1]);
    if (is_file($resetFile)) {
        unlink($resetFile);
        break;
    }
    $cron->run();
    sleep($cron->getPauseTime());
}
