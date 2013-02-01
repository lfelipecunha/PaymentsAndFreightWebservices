<?php

class DbTable_Abstract {

    protected $tableName = null;

    public function fetchRow($options) {
        $adapter = App_DbAdapter::getAdapter();
        return $adapter->fetchRow($this->_tableName,$options);
    }

    public function fetchAll($options) {
        $adapter = App_DbAdapter::getAdapter();
        return $adapter->fetchAll($this->_tableName,$options);
    }

    public function insert($value) {
        $adapter = App_DbAdapter::getAdapter();
        if ($adapter->insert($this->_tableName,$value)) {
            $id = $adapter->getLastInsertId();
            return $id['id'];
        } else {
            return false;
        }
    }

    public function update($values,$where) {
        $adapter = App_DbAdapter::getAdapter();
        return $adapter->update($this->_tableName,$values,$where);
    }

    public function delete($where) {
        $adapter = App_DbAdapter::getAdapter();
        return $adapter->delete($this->_tableName,$where);
    }
}
