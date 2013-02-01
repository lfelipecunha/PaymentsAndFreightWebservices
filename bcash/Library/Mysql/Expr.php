<?php

class Mysql_Expr
{
	protected $_expr;
	public function __construct($expr) {
		$this->_expr = $expr;
	}

	public function getExpr() {
		return $this->_expr;
	}
}
