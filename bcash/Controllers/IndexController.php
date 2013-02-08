<?php

class App_Controllers_IndexController extends Controller {
    public function indexAction() {
        if (!$this->_requestHandler->isPost()) {
            $response = array('O acesso a este serviço é somente por POST');
        } else {
            $container = new App_Models_Containers_Order();
            $data = $this->_requestHandler->getPost();
            if (!$container->isValid($data)) {
                $response = array('code' => 0,'errors' => $container->getInvalidFields());
            } else {
                $info = $container->getValues();
                $model = new App_Models_DbTable_Order();
                $id = $model->insert(array('valores' => $info));
                $response = array('code' => $id,'message' => 'Em processo de pagamento');
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function installmentAction() {

        if (!$this->_requestHandler->isPost()) {
            $response = array('O acesso a este serviço é somente por POST');
        } else {
            $container = new App_Models_Containers_Installments();
            $data = $this->_requestHandler->getPost();
            if (!$container->isValid($data)) {
                $response = array('errors' => $container->getInvalidFields());
            } else {
                $info = $container->getValues();
                $installment = new App_Models_Installments($info['valorTotal'],(array)$info['prestacoesComAcrescimo']);
                $response = array('parcelas' => $installment->getInstallments());

            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
