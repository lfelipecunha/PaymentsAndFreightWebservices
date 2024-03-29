<?php
/**
 * Classe que cálcula o preço e o prazo para o frete quando o(s) produto(s)
 * for(em) retirado(s) na loja.
 *
 */
class Application_Model_RetiraNaLoja implements Application_Model_Frete
{
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

	/**
	 * Construtor da classe
	 *
	 * @param mixed $params Parâmetro obrigatório mas não utilizado
	 * @param array $opcao  Parâmetro com o valor adicional do frete
	 */
	public function __construct($params,$opcao) {
		// se o valor adicional estiver setado seta o valor do frete com este
		// valor
		if (!empty($opcao['valor_servico_adicional'])) {
			$this->_valor = (int)$opcao['valor_servico_adicional'];
		}

		if (!empty($opcao['prazo_entrega'])) {
			$this->_prazo = (int)$opcao['prazo_entrega'];
		}
	}

	/**
	 * Método para retorno do valor e prazo de entrega do frete
	 *
	 * @return array
	 */
	public function consulta() {
		return array(
			'prazo' => $this->_prazo,
			'valor' => $this->_valor,
			'erro'  => 0,
		);
	}
}
