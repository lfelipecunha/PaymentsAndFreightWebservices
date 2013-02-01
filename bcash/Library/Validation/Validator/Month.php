<?php

class Validation_Validator_Month extends Validation_Validator_Abstract {

    public function isValid($value) {
        $isValid = true;
        if (!is_numeric($value) || $value < 1 || $value > 12) {
            $this->_errorMessage = sprintf('"%s" não é um mês válido',$value);
            $isValid = false;
        }
        return $isValid;
    }
}
