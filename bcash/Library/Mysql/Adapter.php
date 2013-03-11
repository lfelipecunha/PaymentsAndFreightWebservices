<?php

class Mysql_Adapter
{
	protected $_params = array();

	protected $_connectionId = null;

	protected $_debugSql = false;

	protected $_lastSql = null;

	public function __construct($host,$username,$password,$databaseName) {
		$this->_params = array(
			'host' => $host,
			'username' => $username,
			'password' => $password,
			'databaseName' => $databaseName,
		);
		$this->_connect();
	}

	public function debugSql($flag) {
		$this->_debugSql = (bool)$flag;
	}

	public function getLastSql() {
		return $this->_lastSql;
	}

	protected function _connect() {
		$this->_connectionId = mysql_connect($this->_params['host'],$this->_params['username'],$this->_params['password']);
		mysql_select_db($this->_params['databaseName']);
	}

	protected function _parseWhere($where, $aditional = 'AND') {
		if ($where instanceof Mysql_Expr) {
			return $where->getExpr();
		} elseif (is_array($where)) {
			$result = '';
			foreach ($where as $key => $value) {
				if (!empty($result)) {
					$result .= ' '.$aditional.' ';
				}
				if ($key == 'or' || $key == 'and') {
					$result .= '('.$this->_parseWhere($value,strtoupper($key)).')';
				} elseif (is_array($value)) {
					foreach ($value as &$aux) {
						$aux = $this->quoteValue($aux);
					}
					$result .= "(".$this->quote($key)." IN(".implode(',',$value).')';
				} elseif (stripos($key,' ') !== false) {
					$result .= "($key ".$this->_parseWhere($value).')';
				} else {
					$result .= '(';
					if (!is_numeric($key)) {
						$result .= $this->quote($key).' = ';
					}
					$result .= $this->_parseWhere($value).')';
				}
			}
			return $result;
		} elseif ($where === null) {
			return '1=1';
		} else {
			return $this->quoteValue($where);
		}
	}

	public function fetchRow($table,$options = array()) {
		$options['limit'] = 1;
		$resource = $this->_fetch($table,$options);
		return mysql_fetch_array($resource,MYSQL_ASSOC);
	}

	protected function _fetch($table, $options = array()) {
		$table = $this->quote($table);

		$columns = '*';
		if (!empty($options['columns'])) {
			$columns = $options['columns'];
		}
		if (!is_array($columns)) {
			$columns = array($columns);
		}

		foreach($columns as $key => &$column) {
			$column = $this->quote($column);
			if (!is_numeric($key)) {
				$column .= ' AS '.$this->quote($key);
			}
		}
		$cols = implode(',',$columns);

		$where = null;
		if (!empty($options['where'])) {
			$where = $options['where'];
		}
		$sql = "SELECT $cols FROM $table WHERE ".$this->_parseWhere($where);
		if (!empty($options['order'])) {
			$sql .= ' ORDER BY '.$options['order'];
		}

		if (!empty($options['limit'])) {
			$sql .= ' LIMIT '.(int)$options['limit'];
		}
		$resource = $this->execute($sql);
		return $resource;
	}

	public function fetchAll($table,$options = array()) {
		$resource = $this->_fetch($table,$options);
		$result = array();
		while ($row = mysql_fetch_array($resource,MYSQL_ASSOC)) {
			$result[] = $row;
		}
		return $result;
	}

	public function insert($table,$values) {
		$table = $this->quote($table);
		$new_values = array();
		foreach ($values as $key => $value) {
			$new_values[$this->quote($key)] = $this->quoteValue($value);
		}
		$cols = implode(',',array_keys($new_values));
		$vals = implode(',',$new_values);
		$sql = "INSERT INTO $table($cols) VALUES($vals)";
		return $this->execute($sql);
	}

	public function delete($table,$where) {
		$table = $this->quote($table);
		$sql = "DELETE FROM $table WHERE ".$this->_parseWhere($where);
		return $this->execute($sql);
	}

	public function update($table, $values, $where = null) {
		$table = $this->quote($table);
		$set = array();
		foreach ($values as $key => $value) {
			$set[] = $this->quote($key).' = '.$this->quoteValue($value);
		}

		$set = implode(',',$set);
		$sql = "UPDATE $table SET $set WHERE ".$this->_parseWhere($where);
		return $this->execute($sql);
	}

	public function quoteValue($value) {
		if (!is_numeric($value) && strtolower($value) != 'null') {
			$value = mysql_real_escape_string($value);
			$value ="'$value'";
		}
		return $value;
	}

	public function quote($data) {
		if($data != '*') {
			$data = "`$data`";
		}
		return $data;
	}

	public function execute($sql) {
		if ($this->_debugSql) {
			echo $sql."\n";
		}
		$this->_lastSql = $sql;
		$resource = mysql_query($sql,$this->_connectionId);
		if ($resource === false) {
			throw new Exception($sql."\n".mysql_error());die;
		}
		return $resource;
	}

	public function getLastInsertId() {
		$sql = 'SELECT LAST_INSERT_ID() AS id';
		$resource = $this->execute($sql);
		return mysql_fetch_array($resource,MYSQL_ASSOC);
	}
}
