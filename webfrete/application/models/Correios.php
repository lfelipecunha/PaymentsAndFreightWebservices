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
	 * @var int
	 */
	protected $_diametro = 5;

	/**
	 * Variável que armazena todas as caixas de produtos de uma solicitação
	 * @var array
	 */
	protected $_caixas = array();

	/**
	 * Variável que tem padrão de valores a serem enviados ao webservice dos
	 * Correios
	 * @var array
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
		// seta o diametro padrão
		$params['diametro'] = $this->_diametro;
		// instância do Formulário dos Correios
		$form = new Application_Form_Correios();
		// verifica se os parametros passados são válidos
		if ($form->isValid($params)) { // se são válidos
			// pega os valores filtrados do formulário
			$form_values = $form->getValues();
			// monta os parametros
			$params = array_merge($form_values,$params);

			// laço para pegar os valores padrões de parametros
			foreach ($this->_params as &$value) {
				// para cada valor do atributo de parametros existe parametro
				// uma chave no array de parametros passado, este valor é
				// assumido pelo elemento do array
				$value = $params[$value];
			}
		} else { // caso valores inválidos
			// lança uma execessão
			throw new F1S_Basket_Freight_FreightErrorException('',101);
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
		// instâcia do objeto de Empacotamento
		$empacotador = F1S_Basket_Freight_Packer::getInstance();
		// coloca os produtos nas caixas
		$this->_caixas = $empacotador->getCaixas($produtos);
	}


	/**
	 * Método para realizar consulta com o webservice dos Correios
	 *
	 * Este método realiza tantas requisições quantas caixas de produtos
	 * existirem.
	 *
	 * @return array Valor e Prazo do frete
	 */
	public function consulta() {
		// instância do Soap Client
		$soap_cliente = new Zend_Soap_Client('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL');
		// seta a versão do Soap para 1.1 devido o webservice dos correios
		// funcionar somente com esta versão
		$soap_cliente->setSoapVersion(SOAP_1_1);
		// define o timeout para a conexão do serviço
		$context = stream_context_create(array('http' => array('timeout' => 5)));
		$old = ini_set('default_socket_timeout',5);
		$soap_cliente->setStreamContext($context);

		// inicializa os valores em zero
		$result = array ('valor' => 0, 'prazo' => 0);
		// laço para realização de requisições para cada caixa
		foreach ($this->_caixas as $caixa) {
			// bloco de tentativa de comunicação com o webservice dos correios
			try {
				// seta os parmetros de dimensões de acordo com os mesmos parâmetros
				// da caixa
				$aux['nVlComprimento'] = $caixa['comprimento'];
				$aux['nVlLargura'] = $caixa['largura'];
				$aux['nVlAltura'] = $caixa['altura'];
				$aux['nVlPeso'] = round($caixa['peso']/1000,2);

				// monta os parametros à serem enviados para os Correios
				$params = array_merge($this->_params,$aux);
				// Pega os valores do websevice
				$response = $soap_cliente->CalcPrecoPrazo($params);
				// valores do serviço (PAC, SEDEX, ...)
				$valores = $response->CalcPrecoPrazoResult->Servicos->cServico;
				// Verifica se houve erro na requisição
				if ($valores->Erro == 0) {// se não houve erro
					// realiza castings pois os valores são objetos XML

					$valor = (int)(str_replace(',','',(string)$valores->Valor));

					// valor zerado deve ir para a contingência
					if ($valor == 0) {
						throw new SopaFault();
					}

					// incrementa o valor deste frete no valor total do frete
					$result['valor'] +=  $valor;
					// pega o prazo de entrega
					$prazo = (int)$valores->PrazoEntrega;
					// seta sempre o maior prazo de entrega no prazo de entrega
					// total
					if ($result['prazo'] < $prazo) {
						$result['prazo'] = $prazo;
					}
					// Seta o erro como zero para indicar que não houve erro
					$result['erro'] = 0;
				} else {
					// Condição para verificar se o erro do webservice dos correios foi um erro interno, em caso
					// em caso positivo lança um SopaFault para obter os dados da contingência
					if ($valores->Erro == '99') {
						throw new SoapFault();
					}
					// se houve erro na requisição lança uma excessão
					throw new F1S_Basket_Freight_FreightErrorException('',102);
				}
				if ($result['valor'] <= 1) {
					throw new SoapFault('1','Valor Invalido');
				}
			} catch (SoapFault $sp){ // caso tenha ocorrido algum erro de comunicação com o servidor dos correios
				// inicializa o peso
				$peso = 0;
				// pega o cep de destino
				$cep_destino =$this->_params['sCepDestino'];

				// faz o somatório dos pesos das caixas
				foreach ($this->_caixas as $caixa) {
					$peso += $caixa['peso'];
				}
				// instância de modelo para obtenção dos dados de contingência
				$model = new Application_Model_DbTable_TabelaContingencia();

				// pega os valores da contingência
				$valores = $model->getValuesByTipoFreteCode($this->_params['nCdServico'],$cep_destino);

				// Caso exista contingência para o tipo de frete
				if (!empty($valores)) {
					// seta o prazo de entrega
					$result['prazo'] = $valores[0]['prazo'];

					// se o peso das caixas é maior que 8kg
					if ($peso > 8000) {
						// faz um calculo para pegar o valor referente ao peso
						$result['valor'] = (int)($peso/8000*$valores[0]['valor']);
					} else {
						// se o peso das caixas é inferior ou igual a 8kg seta o
						// valor da tabela de contingência
						$result['valor'] = $valores[0]['valor'];
					}
					// seta o erro igual 999 que indica que os dados vieram de uma
					// contingência
					$result['erro'] = 999;
				} else { // se não existir contingência
					throw new F1S_Basket_Freight_FreightErrorException('',102);
				}
				// interrompe o laço de calculo pois se não houve comunicação
				//com os correios o valor não deve realizar o processo novamente
				break;
			}
		}

		// seta o timeout dos sockets novamente para o padrão
		ini_set('default_socket_timeout',$old);

		// retorna os valor e prazo de entrega
		return $result;
	}
}
