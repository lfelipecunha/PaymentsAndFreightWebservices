<?php
class Zend_Exception_Frete extends Zend_Exception
{
	protected $_xmlMessage;

	public function __construct($message, $code=0) {
		$this->_xmlMessage = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><consulta></consulta>');
		$erro = $this->_xmlMessage->addChild('error');
		if (is_array($message)) {
			foreach ($message as $key => $value) {
				if (is_array($value)) {
					$novo = $erro->addChild($key);
					foreach ($value as $campo => $error) {
						$novo->addChild($campo,utf8_encode($error));
					}
				} else {
					$erro->addChild($key,utf8_encode($value));
				}
			}
		} else {
			$erro->addChild('message',utf8_encode($message));
		}
		parent::__construct($this->_xmlMessage->asXML(), (int) $code);
	}

	public function __toString() {
		parent::__toString();
	}
}