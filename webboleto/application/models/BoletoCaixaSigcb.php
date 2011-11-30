<?php
class Application_Model_BoletoCaixaSigcb extends Application_Model_Boleto
{
	protected $_digitoGeral;
	protected $_codigoBanco = 104;

	public function __construct($params) {
		$this->_init($params,'CAIXA_SIGCB');
	}

	/**
	 * Formata e retorna os valores necess�rios para o boleto
	 *
	 * @return array Valores Formatados
	 */
	public function getParams(){
		// coloca os par�metros da carteira no in�cio do nosso n�mero
		$this->nosso_numero = '24'.$this->nosso_numero;
		// calcula o fator de vencimento para o boleto
		$fator_vencimento = $this->_fatorVencimento($this->vencimento);

		// pega os c�digos para o c�digo de barras e a linha digit�vel
		$codes = $this->_getCodes($this->_params);

		$barcode = $this->_getBarcode($codes['barcode']);

		// pega o logo da caixa
		$logo_caixa = file_get_contents(APPLICATION_PATH.'/../public/img/logocaixa.jpg');

		// novo objeto de data com a data de vencimento
		$data = new Zend_Date($this->vencimento);

		// vari�veis para a camada de visualiza��o
		$vars = array (
			'barcode'         => $barcode,
			'carteira'        => 'SR',
			'codigo_banco'    => $this->_codigoBanco.'-'.$this->_modulo10($this->_codigoBanco),
			'codigo_cedente'  => $this->codigo_cedente.'-'.$this->_modulo10($this->codigo_cedente),
			'data_hoje'       => date('d/m/Y'),
			'especie'         => 'R$',
			'linha_digitavel' => $codes['linha_digitavel'],
			'logo_caixa'      => base64_encode($logo_caixa),
			'valor'           => number_format(($this->valor/100),2,',','.'),
			'vencimento'      => $data->toString('dd/MM/Y'),
		);
		$vars += $this->_params;
		// adiciona o digito verificador para o campo nosso n�mero
		$vars['nosso_numero'] .= '-'.$this->_modulo11($vars['nosso_numero']);
		return $vars;
	}



	/**
	 * Monta e retorna o Campo livre
	 *
	 * @param string $codigo_cedente C�digo num�rico do cedente
	 * @param string $nosso_numero N�mero de identifica��o do Boleto para a loja
	 * @param int $tipo_registro 1 para Registrado ou 2 para Sem Registro
	 * @return string Campo livre com 25 d�gitos
	 */
	protected function _getCampoLivre($codigo_cedente, $nosso_numero, $tipo_registro = 2) {

		$campo_livre  = $codigo_cedente;
		// digito verificador do c�digo de cedente
		$campo_livre .= $this->_modulo11($codigo_cedente);
		// posi��es 3,4 e 5 do nosso n�mero
		$campo_livre .= substr($nosso_numero, 2,3);
		// tipo de registro
		$campo_livre .= $tipo_registro;
		//posi��es 6,7 e 8 do nosso n�mero
		$campo_livre .= substr($nosso_numero, 5,3);
		// constante para identifica��o de responsabilidade de impress��o do Cedente
		$campo_livre .= 4;
		// da posi��o 9 � posi��o 17 do nosso n�mero
		$campo_livre .= substr($nosso_numero, 8,9);
		// d�gito verificador do nosso n�mero
		$campo_livre .= $this->_modulo11($campo_livre);
		return $campo_livre;
	}

/**
	 * Gera o c�digo num�rico formatado para a linha digit�vel de acordo com a
	 * documenta��o do Caixa
	 *
	 * @param array $params com os dados do boleto
	 * @return string C�digo Gerado
	 */
	protected function _getLinhaDigitavel($params) {

		$codigo_banco = $this->_codigoBanco;
		$moeda = $this->_moeda;

		$campo_livre = $this->_getCampoLivre($params['codigo_cedente'], $params['nosso_numero']);

		$campo1 = $codigo_banco.$moeda.substr($campo_livre, 0, 5);
		$digito_campo1 = $this->_modulo10($campo1);
		$campo1 = substr($campo1, 0, 5).'.'.substr($campo1, 5, 5).$digito_campo1;

		$campo2 = substr($campo_livre, 5,10);
		$digito_campo2 = $this->_modulo10($campo2);
		$campo2 = substr($campo2, 0, 5).'.'.substr($campo2, 5, 5).$digito_campo2;

		$campo3 = substr($campo_livre, 15,10);
		$digito_campo3 = $this->_modulo10($campo3);
		$campo3 = substr($campo3, 0, 5).'.'.substr($campo3, 5, 5).$digito_campo3;

		$campo4 = $this->_digitoGeral;

		$campo5 = $this->_fatorVencimento($params['vencimento']).$params['valor'];

		return "$campo1 $campo2 $campo3 $campo4 $campo5";
	}

	/**
	 * Gera o c�digo num�rico formatado para o c�digo de barras de acordo com a
	 * documenta��o do Caixa
	 *
	 * @param array $params com os dados do boleto
	 * @return string C�digo Gerado
	 */
	protected function _getValorCodigoBarras($params) {
		$codigo_banco = $this->_codigoBanco;
		$moeda = $this->_moeda;
		$fator_vencimento = $this->_fatorVencimento($params['vencimento']);
		$campo_livre = $this->_getCampoLivre($params['codigo_cedente'], $params['nosso_numero']);
		$parte1 = $codigo_banco.$moeda;
		$parte2 = $fator_vencimento.$params['valor'].$campo_livre;
		$digito_geral = $this->_modulo11($parte1.$parte2);
		$this->_digitoGeral = $digito_geral;
		return $parte1.$digito_geral.$parte2;
	}

	/**
	 * Pega os c�digos para gera��o do boleto
	 *
	 * @param array $params Par�metros do boleto
	 * @return array C�digos
	 */
	protected function _getCodes($params) {
		$barcode = $this->_getValorCodigoBarras($params);
		$linha_digitavel = $this->_getLinhaDigitavel($params);
		return array('barcode' => $barcode, 'linha_digitavel' => $linha_digitavel);
	}
}
