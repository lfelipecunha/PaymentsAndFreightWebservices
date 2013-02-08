<?php

class App_Services_Comunication extends App_Services_Abstract {

    public function run() {
        $time = $this->getPauseTime();
        $table = new App_Models_DbTable_Order();
        $adapter = App_DbAdapter::getAdapter();
        $data = $table->fetchAll(array('where' => array('notificada' => 0,new Mysql_Expr('resultado IS NOT NULL')),'columns' => array('id','valores','resultado','data_notificacao')));
        $status = false;
        foreach ($data as $order) {
            $url = $order['valores']['loja']['url'];
            $storeComunication = new App_Models_StoreComunication($url);
            $lastResult = array_pop($order['resultado']);
            $hash = sha1($order['id'].$lastResult['status'].$lastResult['descriptionStatus'].$order['valores']['loja']['token']);
            $message = array('code' => $order['id'],'status' => $lastResult['status'], 'message' => $lastResult['descriptionStatus'],'hash' => $hash);
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
