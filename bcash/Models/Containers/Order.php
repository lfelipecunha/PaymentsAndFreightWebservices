<?php

class App_Models_Containers_Order extends Validation_Container {

    protected $_products = array();

    public function init() {
        $shop = new App_Models_Containers_Shop();
        $this->addSubContainer($shop,'loja');

        $client = new App_Models_Containers_Client();
        $this->addSubContainer($client,'comprador');

        $freight = new App_Models_Containers_Freight();
        $this->addSubContainer($freight,'frete');

        $payment = new App_Models_Containers_Payment();
        $this->addSubContainer($payment,'pagamento');
    }

    public function isValid($data) {
        $isValid = parent::isValid($data);
        if (empty($data['produtos']) || !is_array($data['produtos'])) {
            $this->_invalidFields['produtos'] = 'Ao menos um produto deve ser informado!';
            $isValid = false;
        } else {
            foreach ($data['produtos'] as $produto) {
                $container = new App_Models_Containers_Product();
                if (!$container->isValid($produto)) {
                    $this->_invalidFields['produtos'][] = $container->getInvalidFields();
                    $isValid = false;
                }
                $this->_products[] = $container;
            }
        }
        return $isValid;
    }

    public function getValues() {
        $values = parent::getValues();
        foreach ($this->_products as $product) {
            $values['produtos'][] = $product->getValues();
        }
        return $values;
    }
}
