<?php

class Validation_Validator_Length extends Validation_Validator_Abstract {

    private $_maxLength = 0;

    private $_minLength = 0;

    public function setMaxLength($maxLength) {
        $maxLength = (int)$maxLength;
        if ($maxLength < 0) {
            throw new Exception('Invalid max length with value: '.$maxLength);
        }
        $this->_maxLength = $maxLength;
        return $this;
    }

    public function setMinLength($minLength) {
        $minLength = (int)$minLength;
        if ($minLength < 0) {
            throw new Exception('Invalid min length with value: '.$minLength);
        }
        $this->_minLength = $minLength;
        return $this;
    }

    public function getMinLength() {
        return $this->_minLength;
    }
    public function getMaxLength() {
        return $this->_maxLength;
    }

    public function isValid($value) {
        $min = $this->getMinLength();
        $max = $this->getMaxLength();
        if (strlen($value) >= $min && ($max == 0 || $max >= strlen($value))) {
            return true;
        } else {
            $this->_errorMessage = sprintf('O texto deve conter %d e %d caracteres',$min,$max);
            return false;
        }
    }
}
