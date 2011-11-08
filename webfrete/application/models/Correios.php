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
	public function __construct($params, $opcao){
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
		// laço para cada produto
		foreach ($produtos as $produto) {
			// se uma dimensão for maior que 90cm, se a soma das arestas for
			// maior que 160cm ou se o diâmetro padrão vezes 2 mais o 
			// comprimento do produto for maior que 104cm é lançada uma 
			// Exception pois este produto não pode ser enviado pelos correios.
			if ($produto['largura']    > 90 ||
				$produto['altura']     > 90 ||
				$produto['comprimento'] > 90 ||
				$produto['largura']+$produto['comprimento']+$produto['altura'] > 160 ||
				$this->_diametro*2 + $produto['comprimento'] > 104 ||
				$produto['peso'] > 300000
				) {
				throw new Exception('', 103);
			}

			// Aloca o produto em uma caixa
			$this->_alocaProdutoCaixas($produto);
		}
	}

	/**
	 * Método para alocar um produto em uma caixa.
	 *
	 * Este método verifica se o produto pode ser inserido em uma caixa já
	 * existente. 
	 * Se não existir nenhuma caixa ou as caixas existentes não comportarem este
	 * produto, o mesmo é alocado em uma nova caixa.
	 *
	 * Todo e qualquer produto é tratado como um paralelepipedo, e quando um
	 * produto é inserido em uma caixa que já contenha um produto, esta caixa
	 * recebe a soma dos valores dos lados (comprimento, largura ou altura) da
	 * caixa e do produto dependendo da posição em que o produto foi colocado, e
	 * para as demais dimensões são realizadas comparações para verificação de 
	 * qual é a maior e a caixa recebe o maior valor, permanecendo assim no 
	 * formato de  paralelepipedo.
	 *
	 * @param array $produto Produto contendo o as dimensões, quantidade e peso
	 */
	protected function _alocaProdutoCaixas($produto) {
		// variavel que armazena apenas as dimensões do produto
		$aux_produto = array();
		$aux_produto['comprimento'] = $produto['comprimento'];
		$aux_produto['largura'] = $produto['largura'];
		$aux_produto['altura'] = $produto['altura'];
		// ordena o array para que se tenha prioridade pela medida menor o que
		// facilita o ajuste dos produtos na caixa
		ksort($aux_produto);

		// laço para alocação de produto de acordo com a quantidade
		for ($i = 0; $i < $produto['quantidade'];$i++) {

			// verifica se a caixa está vazia
			if (empty($this->_caixas)) {
				// aloca o produto na primeira caixa
				$this->_caixas[] = $produto;
			} else {
				// flag para verificação se foi possível a alocação do produto
				$flag = false;

				// laço para cada medida do produto
				foreach($aux_produto as $key => $value) {
					// laço para cada caixa existente
					foreach ($this->_caixas as &$caixa) {
						// verifica se o peso da caixa com o novo produto é 
						// inferior ou igual a 30kg
						if ($caixa['peso']+$produto['peso'] <= 30000) {
							// calcula a soma das arestas do conteúdo da caixa
							$soma_arestas = $caixa['altura'] + $caixa['largura'] + $caixa['comprimento'];
							// verifica se adicionando o produto nesta caixa não
							// ultrapassará o limite de soma de arestas de 160cm
							if ($value+$soma_arestas <= 160) {
								// soma o lado da caixa com o lado do produto
								$total_lado = $caixa[$key] + $value;
								// verifica se a caixa não ultrapassará o limite
								// do tamamnho do lado que é 90cm
								if ($total_lado <= 90) {
									// laço para inserir o produto na caixa
									foreach ($aux_produto as $indice => $valor) {
										// verifica se o lado da caixa é o mesmo
										// lado ao qual foi colocado o produto
										if ($indice == $key) {
											// atualiza o tamanho do lado
											$caixa[$indice] = $total_lado;
										} else {
											// se o lado do produto for maior 
											// que o lado da caixa, a caixa 
											// passa ter o tamanho do produto
											if ($aux_produto[$indice] > $valor) {
												$caixa[$indice] = $aux_produto[$indice];
											}
										}
										// atualiza o peso da caixa
										$caixa['peso'] += $produto['peso'];
										// seta a flag de informação de inserção
										// para verdadeiro
										$flag = true;
									}
								}
							}
						}
						// se o produto foi adicionado sai do laço de caixas
						if ($flag) {
							break;
						}
					}
				}

				// verifica se o produto foi adicionado em uma caixa já 
				// existente, caso não tenha sido aloca em um nova caixa.
				if (!$flag) {
					$this->_caixas[] = $produto;
				}
			}
		}
	}

	public function consulta() {
	Zend_Debug::dump($this->_caixas);die;
		$soap_cliente = new Zend_Soap_Client('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL');
		$soap_cliente->setSoapVersion(SOAP_1_1);
		$result = array ('valor' => 0, 'prazo' => 0);
		foreach ($this->_caixas as $caixa) {
			$aux['nVlComprimento'] = $caixa['comprimento'];
			$params = array_merge($this->_params,$aux);
			$result = $soap_cliente->CalcPrecoPrazo($params);
			$valores = $result->CalcPrecoPrazoResult->Servicos->cServico;
			$result = array();
			if ($valores->Erro == 0) {
				$result['valor'] += (float)$valores->Valor;
				$prazo = (string)$valores->PrazoEntrega;
				if ($result['prazo'] < $prazo) {
					$result['prazo'] = $prazo;
				}
			} else {
				throw new Exception('',102);
			}
		}
		$result['valor'] = str_replace(',', '', $result['valor']);
		return $result;
	}
}
