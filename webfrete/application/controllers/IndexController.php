<?php

class IndexController extends Zend_Controller_Action
{

	/**
	 * A��o respons�vel pela realiza��o de consultas de valor e prazo de fretes
	 */
	public function indexAction()
	{
		// verifica se o houve envio de dados por POST
		if ($this->getRequest()->isPost()) { // se houve envio
			// pega os dados do POST
			$params = $this->getRequest()->getPost();
		} else if($this->getRequest()->isGet()) {
			$params = $this->getRequest()->getQuery();
		}
if (!empty($params)) {
			// inst�ncia do Modelo de valida��o de dados padr�es
			$validate = new Application_Model_Validate($params);
			// pega os dados validados. Neste ponto podem ser lan�adas exce��es
			$params = $validate->validaParams();

			// verifica se os par�metros de filtragem para jadlog foram passados
			$jadlog_preco = false;
			if ($params['jadlog_preco'] !== null) {
				$jadlog_preco = true;
			}
			$jadlog_prazo = false;
			if ($params['jadlog_prazo'] !== null) {
				$jadlog_prazo = true;
			}


			// inst�ncia do objeto de Tabela de Tipo de Frete
			$tipo_frete = new Application_Model_DbTable_TipoFrete();
			// inicializa��o de array dos tipos de fretes
			$fretes = array();
			// inicializa��o do array de fretes da jad_log
			$jad_log_fretes = array();
			// la�o para obten��o dos valores e prazos de frete para cada opcao
			// passada por par�metro
			foreach ($params['opcoes'] as $opcao) {
				// pega os dados do tipo de frete de acordo com o c�digo do tipo
				$dados = $tipo_frete->getById($opcao['codigo']);
				// grupo do tipo de frete. Utilizado para definir qual classe de 
				// modelo ser� utilizada
				$grupo = $dados[0]['nome_grupo'];

				$codigo_tipo_frete = $dados[0]['codigo_tipo_frete'];

				$params['codigo_tipo_frete'] = $codigo_tipo_frete;

				// nome do tipo de frete. Utilizado no retorno dos dados
				$nome = $dados[0]['nome_tipo_frete'];

				try {
					// inst�ncia de filtro para montagem do nome da classe
					$filtro = new Zend_Filter_Word_UnderscoreToCamelCase();
					// nome da classe de modelo para obten��o dos dados
					$nome_classe = 'Application_Model_'.$filtro->filter($grupo);
					// inst�ncia do modelo de acordo com o grupo do tipo de 
					// frete. Para obten��o de dados
					$model = new $nome_classe($params,$opcao);

					$dados = $model->consulta();
					// c�digo est� truncado mas n�o foi encontrada outra 
					// alternativa para esta implementa��o
					if (($jadlog_prazo || $jadlog_preco) && $grupo == 'jad_log') {
						$jadlog_fretes[$nome] = $dados;
						$jadlog_fretes[$nome]['codigo'] = $opcao['codigo'];
						$jadlog_fretes[$nome]['nome'] = $nome;
					} else {
						// armazena os dados do frete no array de fretes
						$fretes[$grupo][$nome] = $dados;
						$fretes[$grupo][$nome]['codigo'] = $opcao['codigo'];
					}

				} catch (F1S_Basket_Freight_FatalErrorException $e) { 
					// Se houve um erro que � essencial para o sistema, o mesmo
					// � lan�ado novamente para que seja tratado pelo mecanismo
					// respons�vel. Vide documenta��o sobre tratamento de erros
					// no arquivo TratamentoErros.txt
					throw $e;
				} catch (F1S_Basket_Freight_FreightErrorException $e) {
					// Se houve uma exce��o qualquer pega o c�digo
					$fretes[$grupo][$nome]['erro'] = $e->getCode();
				}
			}

			// configura��es para inser��o do menor pre�o e menor prazo
			if (!empty($jadlog_fretes)) {
				$aux = array();
				$frete = null;
				if ($jadlog_preco) {
					$campo = 'valor';
					$frete = $this->_getMenorFretePorCampo($jadlog_fretes,$campo);
					$nome = $frete['nome'];
					unset($frete['nome']);
					$frete['menor_preco'] = 1;
					$aux['jad_log'][$nome] = $frete;
				} 
				if ($jadlog_prazo) {
					$campo = 'prazo';
					$frete_prazo = $this->_getMenorFretePorCampo($jadlog_fretes,$campo);
					if ($frete === null || $frete['prazo'] > $frete_prazo['prazo']) {
						$nome = $frete_prazo['nome'];
						unset($frete_prazo['nome']);
						$frete_prazo['menor_prazo'] = 1;
						$aux['jad_log'][$nome] = $frete_prazo;
					}
				}
				$fretes += $aux;
			}

			// Cria��o de objeto de XML para gera��o do retorno
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><consulta></consulta>');
			// la�o para inser��o dos tipos de frete no xml
			foreach ($fretes as $tipos) {
				// la�o para cada tipo de frete
				foreach ($tipos as $nome => $valores) {
					// adiciona um Filho para o Xml. nome do tipo de frete
					$tipo = $xml->addChild(strtolower(str_replace(' ','',$nome)));
					// adiciona um filho para o tipo de frete com o nome do tipo
					$tipo->addChild('nome',$nome);
					// la�o para acessar os dados do tipo de frete
					foreach ($valores as $key => $value) {
						// adiciona um Filho para o tipo de frete com o dado
						$tipo->addChild($key, $value);
					}
				}
			}
			// seta o Cabe�alho da p�gina para renderiza��o de XML
			$this->getResponse()->setHeader('Content-type','text/xml');
			// envia o XML para camada de visualiza��o
			$this->view->xml = $xml;
		} else { // se o accesso ao servi�o n�o foi por POST
			// lan�a erro
			throw new F1S_Basket_Freight_FatalErrorException('O acesso � este servi�o � somente por POST!');
		}
	}
	
	/**
	 * M�todo para ordernar fretes por um campo.
	 * Utiliza Quick Sort
	 *
	 * Este m�todo perde as informa��es de chave do primeiro n�vel
	 *
	 * @param array $fretes Fretes a serem ordenados
	 * @param string $campo Campo par�metro de orden��o
	 * @return array Valores ordenados
	 */
	protected function _ordenaFretesPorCampo($fretes,$campo) {
		$menores = array();
		$maiores = array();
		$valor = array_pop($fretes);
		foreach ($fretes as $key => $value) {
			if ($value[$campo] > $valor[$campo]) {
				$maiores[$key] = $value;
			} else {
				$menores[$key] = $value;
			}
		}
		if (!empty($menores)) {
			$menores = $this->_ordenaFretesPorCampo($menores,$campo);
		}
		if (!empty($maiores)) {
			$maiores = $this->_ordenaFretesPorCampo($maiores,$campo);
		}
		return array_merge($menores,array($valor),$maiores);
	}

	/**
	 * Retorna o menor frete com base em um campo
	 *
	 * @param array $fretes Fretes
	 * @param string $campo campo base para verifica��o
	 * @return array Frete com o menor valor no campo passado
	 */
	protected function _getMenorFretePorCampo($fretes,$campo) {
		$fretes = $this->_ordenaFretesPorCampo($fretes,$campo);
		return array_shift($fretes);
	}

	/**
	 * A��o respons�vel pela consulta de todos os valores de cada tipo de frete
	 */
	public function consultaAction() {
		// Cria��o de objeto de XML para gera��o do retorno
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><consulta></consulta>');
		$model = new Application_Model_DbTable_TipoFrete();
		$result = $model->getAllTypesWithParams();
		if (!empty($result)) {
			$filtro = new Zend_Filter_Word_UnderscoreToCamelCase();
			foreach ($result as $tipo) {
				$nome_tipo = $tipo['nome_tipo_frete'];
				$nome_tipo = explode(' ',$nome_tipo);
				if (count($nome_tipo) > 1){
					$nome_tipo = $nome_tipo[1];
				} else {
					$nome_tipo = $nome_tipo[0];
				}

				$nome = $filtro->filter($tipo['nome_grupo']).'_'.$nome_tipo.'_'.$tipo['codigo_tipo_frete'];
				$parametros = $nome.'_parametos';
				if (!isset($$nome)){
					$$nome = $xml->addChild($nome);
					$$nome->addChild('codigo', $tipo['id_tipo_frete']);
					$$nome->addChild('nome',str_replace('_',' ',$nome));
					$$parametros = $$nome->addChild('parametros');
				}
				$$parametros->addChild('parametro',$tipo['nome_parametro']);
			}
			// seta o Cabe�alho da p�gina para renderiza��o de XML
			$this->getResponse()->setHeader('Content-type','text/xml');
			// envia o XML para camada de visualiza��o
				$this->view->xml = $xml;
		} else {
			throw new F1S_Basket_Freight_FatalErrorException('N�o existem tipos de frete!');
		}
	}
}

