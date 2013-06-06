<?php

class App_Models_Containers_Client extends Validation_Container {

    public function init() {
        $email = new Validation_Element('email');
        $email
            ->addValidator(new Validation_Validator_Email())
            ->addValidator(new Validation_Validator_Length(array('maxLength' => 80)));
        $this->addElement($email);

        $name = new Validation_Element('nome');
        $name->addValidator(new Validation_Validator_Length(array('maxLength' => 80)));
        $this->addElement($name);

        $cpf = new Validation_Element('cpf');
        $cpf->addValidator(new Validation_Validator_Cpf());
        $this->addElement($cpf);

        $phone = new Validation_Element('telefone');
        $phone
            ->addValidator(new Validation_Validator_Numeric())
            ->addValidator(new Validation_Validator_Length(array('maxLength' => 11,'minLength' => 10)));
        $this->addElement($phone);

        $gender = new Validation_Element('genero');
        $gender->addValidator(new Validation_Validator_In(array('values' => array('M','F'))));
        $this->addElement($gender);

        $address = new App_Models_Containers_Address();
        $this->addSubContainer($address,'endereco');

    }
}
