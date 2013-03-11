<?php

class App_DbAdapter {

    private static $_adapter = null;

    public static function getAdapter() {
        if (self::$_adapter == null) {
            // @todo remover informações estáticas
            self::$_adapter = new Mysql_Adapter('localhost','bcash','bc458jKOuA34','bcash');
        }
        return self::$_adapter;
    }
}
