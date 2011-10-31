<?php
class Application_Model_Boleto
{
	protected $_params = array();

	public function __get($name) {
		$method = 'get' . ucfirst($name);
		$methods = get_class_methods($this);
		if (in_array($method, $methods)) {
			$result = call_user_func(array($this, $method));
		} else {
			if (!isset($this->$name)) {
				throw new InvalidArgumentException("Invalid Parameter: '$name'");
			} else {
				$result = $this->_params[$name];
			}
		}
		return $result;
	}

	public function __set($name, $value) {
		if (!isset($this->$name)) {
			throw new InvalidArgumentException("Invalid Parameter: '$name'");
		}
		$this->_params[$name] = $value;
	}

	public function __isset($name) {
		return array_key_exists($name, $this->_params);
	}

}