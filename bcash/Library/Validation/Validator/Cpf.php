<?php

class Validation_Validator_Cpf extends Validation_Validator_Abstract {

    public function isValid($value) {
        $value = trim($value);
        $isValid = false;
        if (strlen($value) == 11 && is_numeric($value)) {
            $diferentNumbers = false;
            for($i=1;$i<strlen($value);$i++) {
                if ($value[$i] != $value[$i-1]) {
                    $diferentNumbers = true;
                    break;
                }
            }
            if ($diferentNumbers) {
                $cpf = substr($value,0,9);
                $digit1 = $this->_getDigit($cpf,8);
                $cpf .= $digit1;
                $digit2 = $this->_getDigit($cpf,9);
                $cpf .= $digit2;
                if ($value == $cpf) {
                    $isValid = true;
                }
            }
        }

        if (!$isValid) {
            $this->_errorMessage = sprintf('"%s" não é um CPF válido!',$value);
        }

        return $isValid;
    }

    private function _getDigit($value,$maxPos) {
        $total = 0;
        for($i=$maxPos;$i>=0;$i--) {
            $total += $value[$i] * ($maxPos+2-$i);
        }
        $rest = $total%11;
        if ($rest < 2) {
            $digit = 0;
        } else {
            $digit = 11 - $rest;
        }
        return $digit;
    }
}
