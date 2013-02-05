<?php

function __autoLoad($className) {
    $path = explode('_',$className);
    if ($path[0] == 'App') {
        array_shift($path);
    } else {
        array_unshift($path,'Library');
    }
    $classPath = implode(DS,$path);
    $file = APP_PATH.DS.$classPath.'.php';
    if (!is_file($file) || !is_readable($file)) {
        $message = sprintf('Controller "%s" not found! Please insert class "%s" at file "%s"',$className,$className,$file);
        throw new Exception($message);
    }
    require_once $file;
}

function errorHandler($number, $message, $file, $line, $context) {
    addErrorMessage($number,$message,$file,$line);
    return true;
}

set_error_handler('errorHandler');

function shutdown() {
    $last = error_get_last();
    if (!empty($last)) {
        addErrorMessage($last['type'],$last['message'],$last['file'],$last['line']);
    }
}
register_shutdown_function('shutdown');

function addErrorMessage($number,$message,$file,$line) {
    App_Log::addLog('error','Type: '.$number.' | Message: '.$message. ' | File: '.$file.' | Line: '.$line);
}

