<?php

class App_DbAdapter {

    private static $_adapter = null;

    public static function getAdapter() {
        if (self::$_adapter == null) {
            // @todo remover informações estáticas
            self::$_adapter = new Mysql_Adapter('192.168.0.9','dba','dba','bcash_service');
        }
        return self::$_adapter;
    }
}
