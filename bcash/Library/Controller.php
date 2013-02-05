<?php

class Controller {

    private $_requestParams = array();

    public function __construct($params) {
        $this->_requestParams = $params;
    }

    public function beforeAction(){}

}
