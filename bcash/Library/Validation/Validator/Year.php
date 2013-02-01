<?php

class Validation_Validator_Year extends Validation_Validator_Abstract {

    public function isvalid($value) {
        $isValid = true;
        if (!is_numeric($value) || strlen($value) != 4 || $value <= 0) {
            $this->_errorMessage = sprintf('"%s" não é um ano válido',$value);
            $isValid = false;
        }
        return $isValid;
    }
}
