<?php

class App_Models_Containers_Installments extends Validation_Container {

    public function init() {
        $totalValue = new Validation_Element('valorTotal');
        $totalValue->addValidator(new Validation_Validator_Decimal());
        $this->addElement($totalValue);

        $tax = new Validation_Element('prestacoesComAcrescimo');
        $tax->isAllowEmpty(true)->isRequired(false);
        $this->addElement($tax);
    }
}
