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
}
