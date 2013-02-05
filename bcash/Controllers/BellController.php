<?php

class App_Controllers_BellController extends Controller {

    public function indexAction() {
        /*if (!$this->_requestHandler->isPost()) {
            $response = array('O acesso a este serviço é somente por POST');
            header('Content-Type: application/json');
            echo json_encode($response);die;
        }*/

        $transactionId = $this->_requestHandler->getParam('id_transacao');
        $date = $this->_requestHandler->getParam('data_transacao');
        $orderId = $this->_requestHandler->getParam('id_pedido');
        $status = $this->_requestHandler->getParam('status');
        $statusCode = $this->_requestHandler->getParam('cod_status');
        $originalValue = $this->_requestHandler->getParam('valor_original');
        $shopValue = $this->_requestHandler->getParam('valor_loja');
        $table = new App_Models_DbTable_Order();
        $order = $table->findById($orderId);
        if (empty($order)) {
        }
    }
}
