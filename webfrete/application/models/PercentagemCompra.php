<?php
class Application_Model_PercentagemCompra implements Application_Model_Frete
{
	protected $_prazo;

	protected $_valor;

	/**
	 * Construtor da classe
	 *
	 * @param array $params Parâmetro com o valor dos produtos
	 * @param array $opcao  Parâmetro com o valor adicional do frete
	 */
	public function __construct($params,$opcao) {
		$this->_valor = $this->_calculaValor($params['valor_produtos'],$opcao['percentagem'],$opcao['valor_maximo_frete']);
		$this->_prazo = $opcao['prazo_entrega'];
	}

	/**
	 * Calcula o valor do frete
	 *
	 * @param int $valor_produtos Valor dos produtos em Centavos
	 * @param int $percentagem    Valor percentual com casas decimais mas sem
	 *                            vírgula exemplo: para 6% -> 600
	 * @return int Valor do frete em centavos
	 */
	private function _calculaValor($valor_produtos,$percentagem, $valor_maximo_frete) {
		$valor_frete = round($valor_produtos*$percentagem/10000);
		if (!empty($valor_maximo_frete) && $valor_frete > $valor_maximo_frete) {
			$valor_frete = $valor_maximo_frete;
		}
		return $valor_frete;
	}


	/**
	 * Método para consulta do valor e prazo do frete
	 *
	 * @return array Valor e Prazo do frete
	 */
	public function consulta() {
		return array(
			'prazo' => $this->_prazo,
			'valor' => $this->_valor,
			'erro'  => 0,
		);
	}
}
