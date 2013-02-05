<?php

class App_Log {

    public static function addLog($type,$info) {
        switch ($type) {
            case 'error':
                $file = APP_PATH.DS.'tmp'.DS.'error.log';
                break;
            case 'debug':
            default:
                $file = APP_PATH.DS.'tmp'.DS.'debug.log';
                break;
        }
        $info = date('Y-m-d H:i:s').' -> '.(string)$info."\n";
        file_put_contents($file,$info,FILE_APPEND);
    }


}
