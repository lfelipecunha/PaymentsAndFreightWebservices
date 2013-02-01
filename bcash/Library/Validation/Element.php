<?php

class Validation_Element {
    private $_name;

    private $_validators = array();

    private $_value;

    private $_errors = array();

    private $_isRequired = true;

    private $_allowEmpty = false;

    public function __construct($name) {
        $this->_name = (string)$name;
    }

    public function getName() {
        return $this->_name;
    }

    public function addValidator(Validation_Validator_Abstract $validator) {
        $this->_validators[get_class($validator)] = $validator;
        return $this;
    }

    protected function _getValidators() {
        return $this->_validators;
    }

    public function setValue($value) {
        $this->_value = $value;
        return $this;
    }

    public function getValue() {
        return $this->_value;
    }

    public function isRequired($flag) {
        $this->_isRequired = (bool)$flag;
        return $this;
    }

    public function isAllowEmpty($flag) {
        $this->_allowEmpty = (bool)$flag;
        return $this;
    }

    public function isValid() {
        $isValid = true;
        $value = $this->getValue();

        if ($value === null && $this->_isRequired) {
            $this->_errors['Required'] = 'O campo é requerido!';
            $isValid = false;
        } elseif ($value !== null && $value === '' && !$this->_allowEmpty) {
            $this->_errors['AllowEmpty'] = 'O campo deve ser preenchido!';
            $isValid = false;
        } else if ($value !== null && $value !== '') {
            foreach ($this->_getValidators() as $validator) {
                if (!$validator->isValid($value)) {
                    $this->_errors[get_class($validator)] = $validator->getErrorMessage();
                    $isValid = false;
                }
            }
        }
        return $isValid;
    }

    public function getErrors() {
        return $this->_errors;
    }
}
