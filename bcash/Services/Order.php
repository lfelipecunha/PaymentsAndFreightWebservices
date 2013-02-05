<?php

class App_Services_Order extends App_Services_Abstract{

    public function run() {
        $table = new App_Models_DbTable_Order();
        $time = $this->getPauseTime();
        $status = true;
        $data = $table->fetchAll(array('where' => array('status' => 'AGUARDANDO PROCESSAMENTO')));
        if (empty($data)) {
            $status = false;
        }
        foreach ($data as $order) {
            $loja = $order['valores']['loja'];
            $model = new App_Models_Order($loja['email'],$loja['token'],$loja['consumerKey']);
            $result = $model->insert($order);
            if ($result === false) {
                $status = false;
                break;
            }
            $table->addResultRegistry($result,$order['id']);
            $table->alterStatus('EM ANDAMENTO',$order['id']);
        }

        if ($status) {
            $time = 0;
        } else {
            $time += 30;
            if ($time > 300) {
                $time = 300;
            }
        }
        $this->setPauseTime($time);
    }

}
