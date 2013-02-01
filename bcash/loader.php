<?php

function __autoLoad($className) {
    $path = explode('_',$className);
    if ($path[0] == 'App') {
        array_shift($path);
    } else {
        array_unshift($path,'Library');
    }
    $classPath = implode(DS,$path);
    require_once APP_PATH.DS.$classPath.'.php';
}
