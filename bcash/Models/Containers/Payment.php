<?php

class App_Models_Containers_Payment extends Validation_Container {
    public function init() {
        $discount = new Validation_Element('desconto');
        $discount->addValidator(new Validation_Validator_Decimal());
        $this->addElement($discount);

        $increase = new Validation_Element('acrescimo');
        $increase->addValidator(new Validation_Validator_Decimal());
        $this->addElement($increase);

        $code = new Validation_Element('codigo');
        $cards = array(
            'Visa' => 1,
            'Mastercard' => 2,
            'Amex' => 37,
            'Diners' => 55,
            'Elo' => 63,
            'Hipercard' => 56,
        );
        $code->addValidator(new Validation_Validator_In(array('values' => $cards)));
        $this->addElement($code);

        $installment = new Validation_Element('parcelas');
        $installment->addValidator(new Validation_Validator_Numeric());
        $this->addElement($installment);

        $card = new App_Models_Containers_Card();
        $this->addSubContainer($card,'cartao');

    }
}
