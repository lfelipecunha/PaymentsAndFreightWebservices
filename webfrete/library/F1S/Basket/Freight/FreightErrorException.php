<?php
class F1S_Basket_Freight_FreightErrorException extends Zend_Exception
{
	public function __construct($message, $code) {
		parent::__construct($message,(int)$code);
	}

	public function __toString() {
		parent::__toString();
	}
}
