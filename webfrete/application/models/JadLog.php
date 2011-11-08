<?php
class Application_Model_JadLog implements Application_Model_Frete
{

	protected $_params = array(
		'vModalidade' => 'codigo_tipo_frete',
		'Password' => 'jadlog_senha',
		'vSeguro' => 'seguro',
		'vVlDec' => 'valor_produtos',
		'vVlColeta' => 'valor_coleta',
		'vCepOrig'  => 'cep_origem',
		'vCepDest' => 'cep_destino',
		'vPeso'   =>  'peso_total',
		'vFrap' => 'pagar_destino',
		'vEntrega' => 'tipo_entrega',
		'vCnpj' => 'cnpj',
	);

	public function __construct($params,$opcao) {
		$this->parseParams($params+$opcao);
	}

	public function parseParams($params) {
		$params['peso_total'] = 0;
		foreach ($params['produtos'] as $produto) {
			$params['peso_total'] += $produto['peso'];
		}
		$form = new Application_Form_JadLogConsulta();
		if ($form->isValid($params)) {
			$form_values = $form->getValues();
			$params = array_merge($form_values,$params);
			foreach ($this->_params as &$value) {
				$value = $params[$value];
			}
			$this->_params['vVlDec'] = $this->_formatNumber($this->_params['vVlDec']/100);
			$this->_params['vPeso'] = $this->_formatNumber($this->_params['vPeso']/1000);
		}else {
			throw new Exception('',101);
		}
	}

	protected function _formatNumber($number) {
		return number_format($number,2,',','');
	}

	public function consulta(){
		$soap_client = new Zend_Soap_Client('http://jadlog.com.br/JadlogEdiWs/services/ValorFreteBean?WSDL');
		$result = $soap_client->valorar($this->_params);
		$xml = simplexml_load_string($result->valorarReturn);
		$valor_frete = (string)$xml->Jadlog_Valor_Frete->Retorno;
		if ($valor_frete < 0) {
			throw new Exception('',103);
		}
		$valor_frete = explode(',', $valor_frete);
		if (strlen($valor_frete[1]) == 1) {
			$valor_frete[1] .= 0;
		}
		$valor_frete = implode('', $valor_frete);
		return array('valor' => $valor_frete);
	}
}