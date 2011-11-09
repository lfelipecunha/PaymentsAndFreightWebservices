<?php

/**
 * Classe de Camada de modelo responsável pela obtenção dos valores de frete dos
 * Correios.
 *
 * Esta classe implementa a interface de Frete.
 */
class Application_Model_Correios implements Application_Model_Frete
{
	/**
	 * Parâmetro com o valor padrão para o diametro de produto
	 */
	protected $_diametro = 5;

	/**
	 * Variável que armazena todas as caixas de produtos de uma solicitação
	 */
	protected $_caixas = array();

	/**
	 * Variável que tem padrao de valores a serem enviados ao webservice dos 
	 * Correios
	 */
	protected $_params = array(
		'nCdEmpresa'          => 'correios_login',
		'sDsSenha'            => 'correios_senha',
		'nCdServico'          => 'codigo_tipo_frete',
		'sCepOrigem'          => 'cep_origem',
		'sCepDestino'         => 'cep_destino',
		'nCdFormato'          => 'formato',
		'nVlDiametro'         => 'diametro',
		'sCdMaoPropria'       => 'servico_adicional',
		'nVlValorDeclarado'   => 'valor_servico_adicional',
		'sCdAvisoRecebimento' => 'aviso_recebimento',
	);

	/**
	 * Construtor da classe
	 *
	 * @param array $params Parametros para envio ao webservice
	 * @param array $opcao Valores da opção de Frete
	 */
	public function __construct($params, $opcao) {
		$this->_parseParams($params+$opcao);
		$this->_setProdutos($params['produtos']);
	}

	/**
	 * Método para parsemanto de informaçõe
	 * 
	 * Este método pega os valores padrões dos parâmetros e modifica o nome dos
	 * mesmos de acordo com os valores necessários para envio destes ao 
	 * webservice dos correios
	 *
	 * @param array $params Valores padrões para consulta 
	 *                      vide a documentação
	 */
	protected function _parseParams($params) {
		$params['diametro'] = $this->_diametro;
		$form = new Application_Form_Correios();
		if ($form->isValid($params)) {
			$form_values = $form->getValues();
			$params = array_merge($form_values,$params);
			foreach ($this->_params as &$value) {
				$value = $params[$value];
			}
		} else {
			throw new Exception('',101);
		}
	}


	/**
	 * Método para inserção de produtos nas caixas
	 *
	 * Este método verifica se as dimensões e peso do produto estão de acordo 
	 * com o préestabelecido pelos correios, caso contrário lança um Exception
	 * 
	 * @param array $produtos Produtos a serem inseridos
	 */
	protected function _setProdutos($produtos) {
		$empacotador = F1S_Basket_Freight_Packer::getInstance();
		$this->_caixas = $empacotador->getCaixas($produtos);
	}


	public function consulta() {
		$soap_cliente = new Zend_Soap_Client('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL');
		$soap_cliente->setSoapVersion(SOAP_1_1);
		$result = array ('valor' => 0, 'prazo' => 0);
		foreach ($this->_caixas as $caixa) {
			$aux['nVlComprimento'] = $caixa['comprimento'];
			$aux['nVlLargura'] = $caixa['largura'];
			$aux['nVlAltura'] = $caixa['altura'];
			$aux['nVlDiametro'] = $this->_diametro;
			$aux['nVlPeso'] = round($caixa['peso']/1000,2);
			$params = array_merge($this->_params,$aux);
			$response = $soap_cliente->CalcPrecoPrazo($params);
			$valores = $response->CalcPrecoPrazoResult->Servicos->cServico;
			if ($valores->Erro == 0) {
				$result['valor'] += (int)(str_replace(',','',(string)$valores->Valor));
				$prazo = (string)$valores->PrazoEntrega;
				if ($result['prazo'] < $prazo) {
					$result['prazo'] = $prazo;
				}
			} else {
				throw new Exception('',102);
			}
		}
		$result['erro'] = 0;

		return $result;
	}
}
