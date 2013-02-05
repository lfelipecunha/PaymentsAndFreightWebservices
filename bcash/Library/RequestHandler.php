<?php

class RequestHandler {

    private $_controller;

    private $_params;

    public function __construct(Controller $controller, array $params) {
        $this->_controller = $controller;
        $this->_params = $params;
    }

    public function is($type) {
        return strcasecmp($type,$_SERVER['REQUEST_METHOD']) == 0;
    }

    public function get($type) {
        switch (strtolower($type)) {
            case 'post':
                $result = $this->_getPost();
                break;
            case 'query':
                $result = $this->_getQuery();
                break;
            default:
                $result = null;
                break;
        }
        return $result;
    }

    public function getParam($name) {
        $params = $this->_params;
        if (array_key_exists($name,$params)) {
            return $params[$name];
        }

        if (array_key_exists($name,$params['named'])) {
            return $params['named'][$name];
        }

        $query = $this->_getQuery();
        if (array_key_exists($name,$query)) {
            return $query[$name];
        }

        $post = $this->_getPost();
        if (array_key_exists($name,$post)) {
            return $post[$name];
        }

        return null;
    }

    private function _getPost() {
        return $_POST;
    }

    private function _getQuery() {
        $get = $_GET;
        unset($get['url']);
        return $get;
    }

    public function __call($method, $args) {
        if (preg_match('/^(is|get)(.+)/',$method,$match)) {
            $method = $match[1];
            $value = $match[2];
            return $this->$method($value);
        }
    }



}
