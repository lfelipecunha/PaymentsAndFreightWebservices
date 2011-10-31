<?php
class BoletoController extends Zend_Controller_Action {

	public function indexAction() {
		$params = array();
		$errors = array();
		$vars = array();
		$boleto_nome = null;
		// se recebeu dados por POST
		if ($this->getRequest()->isPost()){
			$params = $this->getRequest()->getPost();
		} elseif ($this->getRequest()->isGet()) {
			$params = $this->getRequest()->getQuery();
		}
		if (!empty($params)) {
			$form = new Application_Form_Boleto();
			// verifica se os dados são válidos
			if (!$form->isValid($params)){
				$errors = $form->getMessages();
			}else {
				// pega o ip do cliente acessou
				$ip_cliente = $this->getRequest()->getServer('REMOTE_ADDR');

				// regista o log da solicitação no banco de dados
				$log = new Application_Model_DbTable_Logs();
				$log->generateLog($params, $ip_cliente,$params['boleto']);
				// pega os parâmetros já filtrados do formulário
				$params = $form->getValues();

				// formatação para o nome da classe
				$boleto_nome = strtolower($params['boleto']);
				$boleto_nome = implode(' ',explode('_',$boleto_nome));
				$boleto_nome = str_replace(' ', '', ucwords($boleto_nome));

				// instancia a classe do boleto
				$reflection = new Zend_Reflection_Class('Application_Model_Boleto'.$boleto_nome);

				// verifica se a classe é subclasse da classe pai de boletos
				if ($reflection->isSubclassOf('Application_Model_Boleto')) {
					$boleto = $reflection->newInstance($params);
					// parametros do boleto para camade de visualização
					$vars = $boleto->getParams();
					$boleto_nome = strtolower($boleto_nome);
				} else {
					$errors = array('Controladora' => 'Controladora Inválida');
				}
			}
		} else {
			$errors = array('Sem Parâmetros' => 'Parâmetros são obrigatórios');
		}
		// envia as variáveis para a camada de visualização
		$this->view->vars = $vars;
		$this->view->errors = $errors;
		$this->view->boleto_nome = $boleto_nome;
		$this->view->xml = new SimpleXMLElement('<?xml version=\'1.0\' encoding="ISO-8859-1"?><consulta></consulta>');
	}

	public function consultaAction(){
		$result = array('errors'=>1,'descricao' => 'Parâmetros inválidos');
		if ($this->getRequest()->isGet()){
			$params = $this->getRequest()->getQuery();
			$boleto = new Application_Model_DbTable_Boleto();
			if (!empty($params['boleto_nome'])) {
				$boleto_nome = strtoupper($params['boleto_nome']);
				if (isset($params['estaticos'])) {
					$static = true;
				} else {
					$static = false;
				}
				$parmas_boleto = $boleto->getParams($boleto_nome,$static);
				$result = array();
				$result['errors'] = 0;
				foreach ($parmas_boleto as $param){
					$result[] = $param;
				}
			} else if(isset($params['lista_boletos'])){
				$result = array();
				$result = $boleto->getBoletosDisponiveis();
			}

		}

		$xml = new SimpleXMLElement('<?xml version=\'1.0\' encoding="ISO-8859-1"?><consulta></consulta>');
		$cont = 1;
		foreach ($result as $key => $value) {
			if (!is_numeric($key)) {
				$xml->addChild($key, $value);
			} else {
				if (!isset($parametros)) {
					$parametros = $xml->addChild('parametros','');
				}
				$parametros->addChild('parametro_'.$cont++, $value);
			}
		}
		$this->view->xml = $xml;


	}
}
