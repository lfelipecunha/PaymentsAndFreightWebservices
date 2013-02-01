<?php

class Validation_Validator_Email extends Validation_Validator_Abstract {
    const CHARS = '[a-z0-9_.]';
    public function isValid($value) {
        $isValid = true;
        $regex = '/^'.self::CHARS.'+@'.self::CHARS.'+\.'.self::CHARS.'+$/i';
        if (preg_match($regex,$value) !== 1) {
            $this->_errorMessage = sprintf('"%s" não é um email válido',$value);
            $isValid = false;
        }
        return $isValid;
    }
}
