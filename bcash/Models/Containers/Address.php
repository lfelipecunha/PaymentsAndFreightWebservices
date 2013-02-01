<?php

class App_Models_Containers_Address extends Validation_Container {

    public function init() {

        $street = new Validation_Element('logradouro');
        $street->addValidator(new Validation_Validator_Length(array('maxLength' => 100)));
        $this->addElement($street);

        $number = new Validation_Element('numero');
        $number->addValidator(new Validation_Validator_Length(array('maxLength' => 10)));
        $this->addElement($number);

        $complement = new Validation_Element('complemento');
        $complement
            ->isRequired(false)
            ->isAllowEmpty(true)
            ->addValidator(new Validation_Validator_Length(array('maxLength' => 80)));
        $this->addElement($complement);


        $neighborhood = new Validation_Element('bairro');
        $neighborhood->addValidator(new Validation_Validator_Length(array('maxLength' => 50)));
        $this->addElement($neighborhood);

        $city = new Validation_Element('cidade');
        $city->addValidator(new Validation_Validator_Length(array('maxLength' => 255)));
        $this->addElement($city);

        $state = new Validation_Element('estado');
        $states=array('AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RO','RS','RR','SC','SE','SP','TO');
        $state->addValidator(new Validation_Validator_In(array('values' => $states)));
        $this->addElement($state);

        $cep = new Validation_Element('cep');
        $cep
            ->addValidator(new Validation_Validator_Length(array('maxLength' => 9)))
            ->addValidator(new Validation_Validator_Numeric());
        $this->addElement($cep);
    }
}
