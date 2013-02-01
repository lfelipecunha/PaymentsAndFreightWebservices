<?php

abstract class App_Crons_Abstract {

    private $_adapter = null;

    public function __construct() {
        $this->init();
    }

    public function init(){}

    protected function _getAdapter() {
        if ($this->_adapter == null) {
            $this->_adapter = App_DbAdapter::getAdapter();
        }
        return $this->_adapter;
    }
}
