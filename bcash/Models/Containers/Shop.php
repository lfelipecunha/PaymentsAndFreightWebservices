<?php

class App_Models_Containers_Shop extends Validation_Container {

    public function init() {
        $email = new Validation_Element('email');
        $email->addValidator(new Validation_Validator_Email());
        $this->addElement($email);

        $token = new Validation_Element('token');
        $this->addElement($token);

        $consumerKey = new Validation_Element('consumerKey');
        $this->addElement($consumerKey);
    }
}
