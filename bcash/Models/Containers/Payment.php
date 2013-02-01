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
        $code->addValidator(new Validation_Validator_In(array('values' => array('5'))));
        $this->addElement($code);

        $installment = new Validation_Element('parcelas');
        $installment->addValidator(new Validation_Validator_Numeric());
        $this->addElement($installment);

        $card = new App_Models_Containers_Card();
        $this->addSubContainer($card,'cartao');

    }
}
