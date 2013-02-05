<?php

abstract class App_Services_Abstract {

    private $_adapter = null;

    private $_pauseTime = 0;

    public function __construct() {
        $this->init();
    }

    public function init(){}

    abstract public function run();

    public function getPauseTime() {
        return $this->_pauseTime;
    }

    public function setPauseTime($time) {
        $this->_pauseTime = abs($time);
        return $this;
    }

    protected function _getAdapter() {
        if ($this->_adapter == null) {
            $this->_adapter = App_DbAdapter::getAdapter();
        }
        return $this->_adapter;
    }

}
