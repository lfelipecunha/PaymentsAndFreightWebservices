<?php
/**
 * Classe respons�vel pelo tratamento de dados para a gera��o de boletos do
 * Bradesco
 */
class Application_Model_BoletoItau extends Application_Model_Boleto
{
	/**
	 * Codigo do Banco
	 * @var string
	 */
	protected $_codigoBanco = '341';

	/**
	 * Construtor da classe
	 *
	 * @param array $params parametros necess�rios para a gera��o do boleto
	 */
	public function __construct($params) {
		// inicializa os atributos do modelo
		$this->_init($params,'ITAU');
	}

	/**
	 * M�todo para obten��o dos valores do boleto j� formatados
	 *
	 * @return array Valores Formatados
	 */
	public function getParams() {
		// pega os n�meros do c�digo de barras
		$codigo_barras = $this->_getValorCodigoBarras();
		// gera o c�digo de barras
		$barcode = $this->_getBarcode($codigo_barras);

		// pega a linha digit�vel
		$linha_digitavel = $this->_getLinhaDigitavel();

		// pega o nosso n�mero
		$nosso_numero = $this->_getNossoNumero();

		// objeto de data para formata��o da data de vencimento
		$data = new Zend_Date($this->vencimento);

		// logo do bradesco
		$logo = file_get_contents(APPLICATION_PATH.'/../public/img/logo-itau.jpg');

		// monta o array com os valores a serem retornados
		$vars = array(
			'barcode'         => $barcode,
			'linha_digitavel' => $linha_digitavel,
			'logo'            => base64_encode($logo),
			'codigo_banco'    => $this->_codigoBanco.'-'.$this->_modulo11($this->_codigoBanco,false),
			'agencia'         => $this->agencia,
			'conta'           => $this->conta.'-'.$this->_modulo10($this->agencia.$this->conta),
			'nosso_numero'    => $nosso_numero.'-'.$this->_modulo10($nosso_numero),
			'data_hoje'       => date('d/m/Y'),
			'vencimento'      => $data->toString('dd/MM/y'),
			'valor'           => number_format(($this->valor/100),2,',','.'),
		);
		$vars += $this->_params;
		return $vars;
	}

	/**
	 * Monta a linha digit�vel do boleto conforme especifica��es do Bradesco
	 *
	 * @return string
	 */
	protected function _getLinhaDigitavel() {
		$nosso_numero = $this->_getNossoNumero();
		$campo1 = $this->_codigoBanco.$this->_moeda.$this->carteira.substr($nosso_numero,0,2);
		$campo1 = $this->_formatCampo($campo1);

		$campo2 = substr($nosso_numero,2,6).$this->_getDacACCN().substr($this->agencia,0,3);
		$campo2 = $this->_formatCampo($campo2);

		$campo3 = substr($this->agencia,3,1).$this->conta.$this->_modulo10($this->agencia.$this->conta).'000';
		$campo3 = $this->_formatCampo($campo3);

		$cod_barras = $this->_getValorCodigoBarras();
		$campo4 = substr($cod_barras,4,1);

		$campo5 = $this->_fatorVencimento($this->vencimento).str_pad($this->valor,10,'0',STR_PAD_LEFT);

		return "$campo1 $campo2 $campo3 $campo4 $campo5";
	}

	protected function _getDacACCN() {
		return $this->_modulo10($this->agencia.$this->conta.$this->carteira.$this->_getNossoNumero());
	}


	/**
	 * M�todo para obten��o da numera��o c�digo de barras, conforme documenta��o
	 * do bradesco
	 *
	 * @return string
	 */
	protected function _getValorCodigoBarras() {
		$parte1 = $this->_codigoBanco.$this->_moeda;
		$parte2 =
			$this->_fatorVencimento($this->vencimento).
			str_pad($this->valor,10,'0',STR_PAD_LEFT).
			$this->carteira.
			$this->_getNossoNumero().
			$this->_getDacACCN().
			$this->agencia.
			$this->conta.
			$this->_modulo10($this->agencia.$this->conta).
			'000';

		$digito = $this->_modulo11($parte1.$parte2);
		return $parte1.$digito.$parte2;
	}

	/**
	 * M�todo que monta e retorna o Campo Livre conforme documenta��o do
	 * bradesco
	 *
	 * @return string
	 */
	protected function _getCampoLivre() {
		return
			$this->agencia.
			$this->carteira.
			$this->_getNossoNumero().
			str_pad($this->conta,7,'0',STR_PAD_LEFT).
			'0';
	}

	/**
	 * M�todo para formata��o e retorno do nosso n�mero, conforme documenta��o
	 * do bradesco
	 *
	 * @return string
	 */
	protected function _getNossoNumero() {
		return str_pad((int)$this->nosso_numero,8,'0',STR_PAD_LEFT);
	}
}
