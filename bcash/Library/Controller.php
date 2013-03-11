<?php

class Controller {

    protected $_requestHandler;

    public function __construct($params) {
        $this->_requestHandler = new RequestHandler($this,$params);
    }

    public function beforeAction(){}


    protected function _sendJsonAndExit(array $info) {
        header('Content-Type: application/json');
        echo json_encode($info);
        exit();
    }

}
