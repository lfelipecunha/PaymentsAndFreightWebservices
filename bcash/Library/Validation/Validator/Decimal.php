<?php

class Validation_Validator_Decimal extends Validation_Validator_Abstract {

    private $_separator = '.';

    public function isValid($value) {
        $isValid = true;
        $separator = $this->getSeparator();
        $regex = '/^\d+$|^\d+\\'.$separator.'\d+$/';
        if (preg_match($regex,$value) !== 1) {
            $this->_errorMessage = sprintf('"%s" não é um valor decimal válido. Ex.: 99%s99',$value,$separator);
            $isValid = false;
        }
        return $isValid;
    }

    public function setSeparator($value) {
        $this->_separator = (string)$value;
        return $this;
    }

    public function getSeparator() {
        return $this->_separator;
    }
}
