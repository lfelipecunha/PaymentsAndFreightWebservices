<?php

abstract class Validation_Validator_Abstract {

    protected $_errorMessage = null;

    protected $_options = array();

    public function __construct(array $options = array()) {
        $this->_setOptions($options);
    }

    private function _setOptions($options) {
        foreach ($options as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this,$method)) {
                $this->$method($value);
            } else {
                $this->_options[$key] = $value;
            }
        }
    }

    abstract public function isValid($value);

    public function getErrorMessage() {
        return $this->_errorMessage;
    }
}
