<?php

class App_Models_Containers_Card extends Validation_Container {
    public function init() {
        $holder = new Validation_Element('titular');
        $holder->addValidator(new Validation_Validator_Length(array('maxLength' => 100)));
        $this->addElement($holder);

        $number = new Validation_Element('numero');
        $number
            ->addValidator(new Validation_Validator_Numeric())
            ->addValidator(new Validation_Validator_Length(array('maxLength' => 30)));
        $this->addElement($number);


        $securityCode = new Validation_Element('codigoSeguranca');
        $securityCode
            ->addValidator(new Validation_Validator_Numeric())
            ->addValidator(new Validation_Validator_Length(array('maxLength' => 6)));
        $this->addElement($securityCode);

        $month = new Validation_Element('mesVencimento');
        $month->addValidator(new Validation_Validator_Month());
        $this->addElement($month);

        $year = new Validation_Element('anoVencimento');
        $year->addValidator(new Validation_Validator_Year());
        $this->addElement($year);
    }
}
