<?php

class App_Controllers_BellController extends Controller {

    public function indexAction() {
        if (!$this->_requestHandler->isPost()) {
            $response = array('error' => 'O acesso a este serviço é somente por POST');
            $this->_sendJsonAndExit($response);
        }

        $orderId = $this->_requestHandler->getParam('id_pedido');
        $table = new App_Models_DbTable_Order();
        $order = $table->findById($orderId);
        if (empty($order)) {
            $this->_sendJsonAndExit(array('error' => 'Pedido Inválido'));
        }

        $model = new App_Models_Order($order['valores']['loja']['email'],$order['valores']['loja']['token'],$order['valores']['loja']['consumerKey']);
        $transactionId = $this->_requestHandler->getParam('id_transacao');
        $date = $this->_requestHandler->getParam('data_transacao');
        $status = $this->_requestHandler->getParam('status');
        $statusCode = $this->_requestHandler->getParam('cod_status');
        $originalValue = $this->_requestHandler->getParam('valor_original');
        $shopValue = $this->_requestHandler->getParam('valor_loja');
        if ($model->verifyStatusCode($transactionId,$status,$statusCode,$originalValue,$shopValue,$orderId)) {
            switch ($statusCode) {
                case 1:
                    $realStatus = 3;
                    break;
                case 2:
                    $realStatus = 5;
                    break;
                case 0:
                default:
                    $realStatus = 1;
                    break;
            }
            if ($table->getStatusByCode($realStatus) != $order['status']) {
                $result = array('transactionId' => $transactionId,'orderId' => $orderId,'status' => $realStatus,'descriptionStatus' => $status);
                $table->addResultRegistry($result,$orderId);
            }
            $this->_sendJsonAndExit(array('error' => 0,'message' => 'Alteração com sucesso'));
        } else {
            $this->_sendJsonAndExit(array('error' => 1,'message' => 'Alteração inválida'));
        }
    }
}
