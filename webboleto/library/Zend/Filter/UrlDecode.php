<?php
class Zend_Filter_UrlDecode extends Zend_Filter_Interface
{

	public function filter ($value){
		return urldecode($value);
	}
}