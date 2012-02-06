<?php

/**
 * Empacotador de Caixas
 *
 * Utilizado pelo Webfrete para criar caixas a partir de pacotes informados pelo
 * cliente. Estrutura��o gen�rica que pode ser utilizada em outros pontos de
 * desenvolvimento, principalmente compartilhando estruturas com os pr�prios
 * sistemas clientes.
 *
 * @category   F1S
 * @package    F1S_Basket
 * @subpackage Freight
 */
class F1S_Basket_Freight_Packer {

	/**
	 * Inst�ncia Singleton
	 * @var F1S_Basket_Freight_Packer
	 */
	private static $_instance = null;

	/**
	 * Caixas de produtos
	 * @var array
	 */
	private $_caixas = array();

	/**
	 * Construtor Singleton
	 */
	private function __construct() {}

	/**
	 * Acesso Singleton
	 *
	 * Ponto de acesso �nico ao empacotador de elementos dentro do sistema.
	 * Somente um objeto do tipo empacotador pode ser instanciado e todos os
	 * elementos ser�o gerenciados por ele.
	 *
	 * @return F1S_Basket_Freight_Packer
	 */
	public static function getInstance() {
		// Busca de Elemento Inicializado
		if (self::$_instance === null) {
			// Inicializa��o de Elemento Singleton
			self::$_instance = new self();
		}
		// Apresenta��o do Objeto Singleton
		return self::$_instance; // Retorno Informado
	}

	/**
	 * M�todo para alocar um produto em uma caixa.
	 *
	 * Este m�todo verifica se o produto pode ser inserido em uma caixa j�
	 * existente.
	 * Se n�o existir nenhuma caixa ou as caixas existentes n�o comportarem este
	 * produto, o mesmo � alocado em uma nova caixa.
	 *
	 * Todo e qualquer produto � tratado como um paralelepipedo, e quando um
	 * produto � inserido em uma caixa que j� contenha um produto, esta caixa
	 * recebe a soma dos valores dos lados (comprimento, largura ou altura) da
	 * caixa e do produto dependendo da posi��o em que o produto foi colocado, e
	 * para as demais dimens�es s�o realizadas compara��es para verifica��o de
	 * qual � a maior e a caixa recebe o maior valor, permanecendo assim no
	 * formato de  paralelepipedo.
	 *
	 * @param array $produto Produto contendo o as dimens�es, quantidade e peso
	 */
	public function addItem($produto) {
		// variavel que armazena apenas as dimens�es do produto
		$aux_produto = array();
		$aux_produto['comprimento'] = $produto['comprimento'];
		$aux_produto['largura'] = $produto['largura'];
		$aux_produto['altura'] = $produto['altura'];
		// ordena o array para que se tenha prioridade pela medida menor o que
		// facilita o ajuste dos produtos na caixa
		ksort($aux_produto);

		// la�o para aloca��o de produto de acordo com a quantidade
		for ($i = 0; $i < $produto['quantidade'];$i++) {

			// verifica se a caixa est� vazia
			if (empty($this->_caixas)) {
				// aloca o produto na primeira caixa
				$this->_caixas[] = $produto;
			} else {
				// flag para verifica��o se foi poss�vel a aloca��o do produto
				$flag = false;

				// la�o para cada medida do produto
				foreach($aux_produto as $key => $value) {
					// la�o para cada caixa existente
					foreach ($this->_caixas as &$caixa) {
						// verifica se o peso da caixa com o novo produto �
						// inferior ou igual a 30kg
						if (($caixa['peso']+$produto['peso']) <= 30000) {
							// calcula a soma das arestas do conte�do da caixa
							$soma_arestas = $caixa['altura'] + $caixa['largura'] + $caixa['comprimento'];
							// verifica se adicionando o produto nesta caixa n�o
							// ultrapassar� o limite de soma de arestas de 160cm
							if ($value+$soma_arestas <= 160) {
								// soma o lado da caixa com o lado do produto
								$total_lado = $caixa[$key] + $value;
								// verifica se a caixa n�o ultrapassar� o limite
								// do tamamnho do lado que � 90cm
								if ($total_lado <= 90) {
									// la�o para inserir o produto na caixa
									foreach ($aux_produto as $indice => $valor) {
										// verifica se o lado da caixa � o mesmo
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
									}
									// atualiza o peso da caixa
									$caixa['peso'] += $produto['peso'];
									// seta a flag de informa��o de inser��o
									// para verdadeiro
									$flag = true;
								}
							}
						}
						// se o produto foi adicionado sai do la�o de caixas
						if ($flag) {
							break;
						}
					}
					// se o produto foi adicionado sai do la�o de caixas
					if ($flag) {
						break;
					}
				}

				// verifica se o produto foi adicionado em uma caixa j�
				// existente, caso n�o tenha sido alocado,
				// aloca em um nova caixa.
				if (!$flag) {
					$this->_caixas[] = $produto;
				}
			}
		}
	}

	/**
	 * M�todo para devolver as caixas j� montadas
	 *
	 * @param array $produto Array com as dimens�es e peso do produto
	 * @return array Caixas com os produtos
	 */
	public function getCaixas($produtos) {
		if (empty($this->_caixas)) {
			// la�o para cada produto
			foreach ($produtos as $produto) {
				// se uma dimens�o for maior que 90cm ou se a soma das arestas
				// for maior que 160cm � lan�ada uma Exception pois este produto
				// n�o pode ser enviado pelos correios.
				if ($produto['largura']    > 90 ||
					$produto['altura']     > 90 ||
					$produto['comprimento'] > 90 ||
					$produto['largura']+$produto['comprimento']+$produto['altura'] > 160 ||
					$produto['peso'] > 30000
					) {
					// esvazia as caixas para que n�o ocorra o envio de outras
					// formas de entrega que dependem das condi��es de tamanho
					$this->_caixas = array();
					throw new F1S_Basket_Freight_FreightErrorException('', 103);
				}
				// Aloca o produto em uma caixa
				$this->addItem($produto);
			}
		}
		$this->_validateCaixas();
		return $this->_caixas;
	}

	/**
	 * Valida as dimens�es das caixas para se adequar as regras de empacotemento
	 * dos correios.
	 *
	 * Este m�todo modifica diretamente o atributo $_caixas
	 */
	private function _validateCaixas() {
		foreach ($this->_caixas as &$caixa) {
			if ($caixa['altura'] > $caixa['comprimento']) {
				$temp = $caixa['altura'];
				$caixa['altura'] = $caixa['comprimento'];
				$caixa['comprimento'] = $temp;
			}
			if ($caixa['largura'] < 11) {
				$caixa['largura'] = 11;
			}
			if ($caixa['altura'] < 2) {
				$caixa['altura'] = 2;
			}
			if ($caixa['comprimento'] < 16) {
				$caixa['comprimento'] = 16;
			}
		}
	}
}

