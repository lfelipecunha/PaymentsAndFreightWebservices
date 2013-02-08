<?php

class App_Models_Installments {

    private $_tax;

    private $_value;

    const MINIMUN_INSTALLMENT_VALUE = 5;

    const TAX = 0.0199;

    public function __construct($value,array $tax) {
        $this->_value = (float)$value;
        $this->_setTax($tax);
    }

    private function _setTax(array $tax) {
        for ($i=2; $i<=12; $i++) {
            if (in_array($i,$tax)) {
                $this->_tax[$i] = true;
            } else {
                $this->_tax[$i] = false;
            }
        }
        return $this;
    }

    public function getInstallments() {
        $result = array(array('parcela' => 1, 'valor' => round($this->_value,2)));
        foreach ($this->_tax as $installment => $tax) {
            if (!$tax) {
                $installmentValue = round($this->_value/$installment,2);
            } else {
                $installmentValue = round($this->_value * pow((1+self::TAX),$installment) / $installment,2);
            }
            if ($installmentValue < self::MINIMUN_INSTALLMENT_VALUE) {
                break;
            }
            $result[] = array('parcela' => $installment, 'valor' => $installmentValue);
        }
        return $result;
    }
}
