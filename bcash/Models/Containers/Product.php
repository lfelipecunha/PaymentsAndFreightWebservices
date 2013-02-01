<?php

class App_Models_Containers_Product extends Validation_Container {

    public function init() {
        $code = new Validation_Element('codigo');
        $code->addValidator(new Validation_Validator_Length(array('maxLength' => 50)));
        $this->addElement($code);

        $name = new Validation_Element('nome');
        $name->addValidator(new Validation_Validator_Length(array('maxLength' => 255)));
        $this->addElement($name);

        $quantity = new Validation_Element('quantidade');
        $quantity->addValidator(new Validation_Validator_Numeric());
        $this->addElement($quantity);

        $price = new Validation_Element('valor');
        $price->addValidator(new Validation_Validator_Decimal());
        $this->addElement($price);
    }
}
