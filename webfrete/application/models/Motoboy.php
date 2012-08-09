<?php

class Application_Model_Motoboy implements Application_Model_Frete {

	/**
	 * Valor do frete em centavos
	 * @var int
	 */
	protected $_valor = 0;

	/**
	 * Prazo de entrega
	 * @var int
	 */
	protected $_prazo = 0;

	protected $_cep = 0;

	/**
	 * Construtor da classe
	 *
	 * @param mixed $params Parâmetro obrigatório mas não utilizado
	 * @param array $opcao  Parâmetro com o valor adicional do frete
	 */
	public function __construct($params,$opcao) {
		$this->_valor = (int)$opcao['valor_servico_adicional'];

		if (!empty($opcao['prazo_entrega'])) {
			$this->_prazo = (int)$opcao['prazo_entrega'];
		}

		$this->_cep = (int)$params['cep_destino'];
	}

	/**
	 * Método para retorno do valor e prazo de entrega do frete
	 *
	 * @return array
	 */
	public function consulta() {
		if ($this->_cep >= 90000001 && $this->_cep <= 91999999) {
			$result = array(
				'prazo' => $this->_prazo,
				'valor' => $this->_valor,
				'erro'  => 0,
			);
		} else {
			$result = array('prazo' => 0,'valor' => 0,'erro' => 1);
		}
		return $result;
	}
}
