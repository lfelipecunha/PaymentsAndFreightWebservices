<?php

class App_Services_Comunication extends App_Services_Abstract {

    public function run() {
        $time = $this->getPauseTime();
        $table = new App_Models_DbTable_Order();
        $data = $table->fetchAll(array('where' => array('notificada' => 0),'columns' => array('id','valores','resultado','data_notificacao')));
        $status = false;
        foreach ($data as $order) {
            $url = '';//@$order['valores']['loja']['url'];
            $storeComunication = new App_Models_StoreComunication($url);
            $lastResult = array_pop($order['resultado']);
            $message = array('code' => $order['id'],'status' => $lastResult['status'], 'message' => $lastResult['descriptionStatus']);
            if ($storeComunication->sendMessage($message)) {
                $values = array('notificada' => 1,'data_notificacao' => date('Y-m-d H:i:s'),'data_penultima_notificacao' => $order['data_notificacao']);
                $table->update($values,array($order['id']));
                $status = true;
            }
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
