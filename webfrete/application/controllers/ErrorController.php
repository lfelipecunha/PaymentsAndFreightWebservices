<?php

class ErrorController extends Zend_Controller_Action
{
	public function errorAction() {
		$errors = $this->_getParam('error_handler');

		$xml = new SimpleXmlElement('<?xml version="1.0" encoding="UTF-8"?><consulta></consulta>');
		$filho = $xml->addChild('error');
		if (!$errors || !$errors instanceof ArrayObject) {
			$filho->addChild('message' => 'Ocorreu um erro no Serviço! Por favor tente novamente mais tarde!');
			$message = $xml->asXml();
		} else {
			if ($this->getInvokeArg('displayExceptions') == true) {
				if ($errors->exception instanceof F1S_Freight_FatalErrorException) {
					$message = $errors->exception->getMessage();
				} else {
					$filho->addChild('message',$errors->exception->getMessage());
					$message = $xml->asXml();
				}
			}
		}
		$this->getResponse()->setHeader('Content-Type', 'text/xml');
		$this->view->message = $message;
	}

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

