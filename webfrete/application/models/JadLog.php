<?php
/**
 * Classe de modelo reponsável pelas requisições com o webservice da JadoLog, 
 * também pelo tratamento de toda e qualquer informação para que estas 
 * requisições sejam bem sucedidas
 *
 */
class Application_Model_JadLog implements Application_Model_Frete
{

	/*
	 * Valores a serem enviados para o webservice
	 * @var array
	 */
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
		'vCnpj' => 'jadlog_login',
	);

	/**
	 * Construtor da classe
	 *
	 * @param array $params Parametros para envio ao webservice
	 * @param array $opcao Valores da opcao de frete escolhida
	 */
	public function __construct($params,$opcao) {
		$this->_parseParams($params+$opcao);
	}

	/**
	 * Método para modificação dos nomes dos parâmetros de acordo com o 
	 * específicado na documentação da JadLog
	 *
	 * @param array $params Parâmetros padrões
	 */
	protected function _parseParams($params) {
		// inicializa o peso total
		$params['peso_total'] = 0;
		// calcula o peso total dos produtos
		foreach ($params['produtos'] as $produto) {
			$params['peso_total'] += $produto['peso'];
		}
		// instância do formulário para consulta da JadLog
		$form = new Application_Form_JadLogConsulta();
		// Verifica se os parâmetros são válidos
		if ($form->isValid($params)) {
			// pega os valores validados do formulário
			$form_values = $form->getValues();
			// monta o array de parâmetros
			$params = array_merge($form_values,$params);
			// seta os parametros de acordo com os valores requisitados
			foreach ($this->_params as &$value) {
				$value = $params[$value];
			}
			// formata valores para duas casas decimais
			$this->_params['vVlDec'] = $this->_formatNumber($this->_params['vVlDec']/100);
			$this->_params['vPeso'] = $this->_formatNumber($this->_params['vPeso']/1000);
		}else { // se não são válidos os parâmetros
			// lança uma exeção
			throw new F1S_Basket_Freight_FreightErrorException('',101);
		}
	}

	/**
	 * Formata um número conforme os padrões da JadLog
	 *
	 * @param string $number Número a ser formatado
	 * @return string Número formatado
	 */
	protected function _formatNumber($number) {
		return number_format($number,2,',','');
	}

	/**
	 * Método para realização de consulta de valor e prazo de frete
	 *
	 * @return array Valor e Prazo do frete
	 */
	public function consulta() {
		// instândo Soap Client
		$soap_client = new Zend_Soap_Client('http://jadlog.com.br/JadlogEdiWs/services/ValorFreteBean?WSDL');
		try {
			// objeto com o resultado  da requisição do webservice
			$result = $soap_client->valorar($this->_params);
		} catch (SoapFault $sp) {
			throw new F1S_Basket_Freight_FreightErrorException('',103);
		}
		// cria xml apartir do resultado
		$xml = simplexml_load_string($result->valorarReturn);
		// pega o valor do frete
		$valor_frete = (string)$xml->Jadlog_Valor_Frete->Retorno;
		// se houver erro no resultado
		if ($valor_frete < 0) {
			throw new F1S_Basket_Freight_FreightErrorException('',103);
		}
		// formata o valor do frete para retorno em sem virgula
		$valor_frete = explode(',', $valor_frete);
		if (count($valor_frete) > 1 ) {
			// verifica se após a virgula tem somente uma casa decimal
			if (strlen($valor_frete[1]) == 1) {
				// adiciona um zero no final pois o numero pode vir com uma casa 
				// decimal
				$valor_frete[1] .= 0;
			}
		} else {
			$valor_frete[1] = '00';
		}
		// agrupa o valor sem a virgula
		$valor_frete = implode('', $valor_frete);

		$jad_log = new Application_Model_DbTable_JadLogPrazo();
		$prazo = $jad_log->getPrazo($this->_params['vCepOrig'],$this->_params['vCepDest'],$this->_params['vModalidade']);
		return array('valor' => $valor_frete,'prazo' => $prazo ,'erro' => 0);
	}
}
