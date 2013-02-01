<?php

class Validation_Validator_Numeric extends Validation_Validator_Abstract {

    private $_withSignal = false;

    public function isValid($value) {
        $isValid = true;
        if (!is_numeric($value) || (!$this->_withSignal && $value <= 0)) {
            $this->_errorMessage = sprintf('"%s" não é um valor numérico válido',$value);
            $isValid = false;
        }
        return $isValid;
    }

    public function setWithSignal($value) {
        $this->_withSignal = (bool)$value;
        return $this;
    }

    public function isWithSignal() {
        return $this->_withSignal;
    }
}
