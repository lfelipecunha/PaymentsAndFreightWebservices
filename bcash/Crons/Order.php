<?php

class App_Crons_Order extends App_Crons_Abstract{

    public function verifyOrders() {
        $table = new App_Models_DbTable_Order();
        $data = $table->fetchAll(array('where' => array('status' => 'AGUARDANDO PROCESSAMENTO')));
        foreach ($data as $order) {
            $loja = $order['valores']['loja'];
            $model = new App_Models_Order($loja['email'],$loja['token'],$loja['consumerKey']);
            $model->insert($order);
        }
    }

}
