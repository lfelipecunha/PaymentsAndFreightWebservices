<?php

class Dispatch {

    private $_url = array(
        'controller' => '',
        'action' => '',
        'pass' => array(),
        'named' => array(),
    );

    public function __construct($url) {
        $this->_setUrl($url);
    }

    private function _setUrl($url) {
        $url = (string)$url;
        $controller = 'Index';
        $action = 'index';
        if (!empty($url)) {
            $url = rtrim($url,'/');
            $url = explode('/',$url);
            $controller = str_replace('.php','',array_shift($url));
            if (!empty($url)) {
                $action = array_shift($url);
                if (!empty($url)) {
                    $this->_setPassedArgs($url);
                }
            }
        }
        $this->_url = array_merge($this->_url,array('controller' => $controller,'action' => $action));
        return $this;
    }

    private function _setPassedArgs(array $args) {
        foreach ($args as $arg) {
            if (preg_match('/^([a-z0-9_\-]+)=(.+)/i',$arg,$match) === 1) {
                $this->_url['named'][$match[1]] = $match[2];
            } else {
                $this->_url['pass'][] = $arg;
            }
        }
        return $this;
    }

    private function _getControllerClass() {
        $controller = $this->_url['controller'];
        return 'App_Controllers_'.$this->_hifenized2CamelCase($controller).'Controller';
    }

    private function _hifenized2CamelCase($word,$isMethod = false) {
        $words = explode('-',$word);
        $final = '';
        foreach ($words as $word) {
            $word = strtolower($word);
            if (!$isMethod || !empty($final)) {
                $word = ucfirst($word);
            }
            $final .= $word;
        }
        return $final;
    }

    private function _getActionName() {
        $action = $this->_url['action'];
        $action = $this->_hifenized2CamelCase($action,true);
        return $action.'Action';
    }

    public function load() {
        $controllerName = $this->_getControllerClass();
        try {
            $controller = new $controllerName($this->_url);
            $controller->beforeAction();
            $action = $this->_getActionName();
            $controller->$action();
        } catch (Exception $e) {
            if (ENVIROMENT == 'production') {
                header('HTTP/1.1 503 Service Unavailable');
                header('Content-Type: application/json');
                echo json_encode(array('code' => 0,'error' => 'Ocorreu um erro no servidor!'));
            } else {
                echo '<h1>'.get_class($e).'</h1>';
                echo '<strong>'.$e->getMessage().'</strong>';
                echo '<pre>';
                echo "\n";
                debug_print_backtrace();
                echo '</pre>';
            }
            die;
        }
    }
}
