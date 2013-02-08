<?php

class Validation_Validator_Url extends Validation_Validator_Abstract {

    public function isValid($url) {
        $isValid = true;
        if (preg_match('/^https?:\/\/[0-9\-_a-z\/]+\.[0-9\-_a-z\/]+/',$url) !== 1) {
            $this->_errors = sprintf('A url "%s" é inválida',$url);
        }
        return $isValid;
    }
}
