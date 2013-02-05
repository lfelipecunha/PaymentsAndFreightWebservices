<?php
$appPath = realpath(dirname(__FILE__));
$filePath = '/tmp'.DIRECTORY_SEPARATOR;
$services = array(
    array('fileName' => 'order.pid','class' => 'Order'),
    array('fileName' => 'comunication.pid','class' => 'Comunication'),
);
foreach ($services as $service) {
    $file = $filePath.$service['fileName'];
    $pid = (int)@file_get_contents($file);
    if (!empty($pid) && posix_kill($pid,SIG_BLOCK)) {
        exit();
    }

    $pid = pcntl_fork();
    switch ($pid) {
        case 0:
            pcntl_exec('/usr/bin/php',array($appPath.DIRECTORY_SEPARATOR.'service.php',$service['class']));
        break;
        default:
            file_put_contents($file,$pid);
        break;
    }
}
