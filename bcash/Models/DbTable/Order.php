<?php

class App_Models_DbTable_Order extends DbTable_Abstract {

    protected $_tableName = 'orders';

    public function insert($data) {
        if (!empty($data['valores'])) {
            $data['valores'] = serialize($data['valores']);
        }
        $data['data_criacao'] = $data['data_modificacao'] = date('Y-m-d H:i:s');
        return parent::insert($data);
    }

    private function  _formatOrder($order) {
        if (!empty($order['valores'])) {
            $order['valores'] = unserialize($order['valores']);
        }
        if (!empty($order['resultado'])) {
            $order['resultado'] = unserialize($order['resultado']);
        }
        return $order;
    }


    public function fetchRow($options) {
        $result = parent::fetchRow($options);
        $result = $this->_formatOrder($result);
        return $result;
    }

    public function fetchAll($options) {
        $result = parent::fetchAll($options);
        foreach ($result as &$order) {
            $order = $this->_formatOrder($order);
        }
        return $result;
    }

    public function addResultRegistry($info,$orderId) {
        $order = $this->fetchRow(array('where' => array('id' => $orderId)));
        if (!empty($order)) {
            $result = array();
            if (!empty($order['resultado'])) {
                $result = unserialize($order['resultado']);
            }
            $result[] = $info;
            $values = array('resultado' => serialize($result),'notificada' => 0);
            $this->update($values,array('id' => $orderId));
        }
    }

    public function update($values,$where) {
        $values['data_modificacao'] = date('Y-m-d H:i:s');
        return parent::update($values,$where);
    }

    public function alterStatus($status,$orderId) {
        return $this->update(array('status' => $status),array('id' => $orderId));
    }
}
