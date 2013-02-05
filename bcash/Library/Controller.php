<?php

class Controller {

    protected $_requestHandler;

    public function __construct($params) {
        $this->_requestHandler = new RequestHandler($this,$params);
    }

    public function beforeAction(){}

}
