<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function _initErrorCatcher() {
		error_reporting(E_ALL | E_STRICT);
		set_error_handler(function($error_type, $error_string, $error_file, $error_line){
			if (APPLICATION_ENV === 'development') {
				$message = array('error_message' => $error_string,'error_file' => $error_file,'error_line' => $error_line,'error_type' => $error_type);
			} else {
				$message = 'Ocorreu um erro no servidor! Em breve o servidor estará em funcionamento! Desculpe o transtorno!';
			}
				throw new Zend_Exception_Frete($message);
		});
	}
}

