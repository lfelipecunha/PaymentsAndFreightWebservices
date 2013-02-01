<?php

class App_Models_Containers_Freight extends Validation_Container {

    public function init() {
        $name = new Validation_Element('nome');
        $name->addValidator(new Validation_Validator_Length(array('maxLength' => 80)));
        $this->addElement($name);

        $price = new Validation_Element('valor');
        $price->addValidator(new Validation_Validator_Decimal());
        $this->addElement($price);

    }
}
