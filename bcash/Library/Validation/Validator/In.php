<?php

class Validation_Validator_In extends Validation_Validator_Abstract {

    private $_values = array();

    public function isValid($value) {
        $isValid = true;
        if (!in_array($value,$this->getValues())) {
            $values = $this->getValues();
            if (count($values) > 2) {
                $last = array_pop($values);
                $values = implode(', ',$values);
                $values .= ' ou '.$last;
            } else {
                $values = current($values);
            }
            $this->_errorMessage = sprintf('O valor deve ser %s',$values);
            $isValid = false;
        }
        return $isValid;
    }

    public function setValues($values) {
        $this->_values = (array)$values;
        return $this;
    }

    public function getValues() {
        return $this->_values;
    }
}
