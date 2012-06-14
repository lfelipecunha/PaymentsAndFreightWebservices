<?php

class IndexController extends Zend_Controller_Action
{

	/**
	 * Ação responsável pela realização de consultas de valor e prazo de fretes
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
			// instância do Modelo de validação de dados padrões
			$validate = new Application_Model_Validate($params);
			// pega os dados validados. Neste ponto podem ser lançadas exceções
			$params = $validate->validaParams();

			// verifica se os parâmetros de filtragem para jadlog foram passados
			$jadlog_preco = false;
			if ($params['jadlog_preco'] !== null) {
				$jadlog_preco = true;
			}
			$jadlog_prazo = false;
			if ($params['jadlog_prazo'] !== null) {
				$jadlog_prazo = true;
			}


			// instância do objeto de Tabela de Tipo de Frete
			$tipo_frete = new Application_Model_DbTable_TipoFrete();
			// inicialização de array dos tipos de fretes
			$fretes = array();
			// inicialização do array de fretes da jad_log
			$jad_log_fretes = array();
			// laço para obtenção dos valores e prazos de frete para cada opcao
			// passada por parâmetro
			foreach ($params['opcoes'] as $opcao) {
				// pega os dados do tipo de frete de acordo com o código do tipo
				$dados = $tipo_frete->getById($opcao['codigo']);
				// grupo do tipo de frete. Utilizado para definir qual classe de 
				// modelo será utilizada
				$grupo = $dados[0]['nome_grupo'];

				$codigo_tipo_frete = $dados[0]['codigo_tipo_frete'];

				$params['codigo_tipo_frete'] = $codigo_tipo_frete;

				// nome do tipo de frete. Utilizado no retorno dos dados
				$nome = $dados[0]['nome_tipo_frete'];

				try {
					// instância de filtro para montagem do nome da classe
					$filtro = new Zend_Filter_Word_UnderscoreToCamelCase();
					// nome da classe de modelo para obtenção dos dados
					$nome_classe = 'Application_Model_'.$filtro->filter($grupo);
					// instância do modelo de acordo com o grupo do tipo de 
					// frete. Para obtenção de dados
					$model = new $nome_classe($params,$opcao);

					$dados = $model->consulta();
					// código está truncado mas não foi encontrada outra 
					// alternativa para esta implementação
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
					// Se houve um erro que é essencial para o sistema, o mesmo
					// é lançado novamente para que seja tratado pelo mecanismo
					// responsável. Vide documentação sobre tratamento de erros
					// no arquivo TratamentoErros.txt
					throw $e;
				} catch (F1S_Basket_Freight_FreightErrorException $e) {
					// Se houve uma exceção qualquer pega o código
					$fretes[$grupo][$nome]['erro'] = $e->getCode();
				}
			}

			// configurações para inserção do menor preço e menor prazo
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

			// Criação de objeto de XML para geração do retorno
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><consulta></consulta>');
			// laço para inserção dos tipos de frete no xml
			foreach ($fretes as $tipos) {
				// laço para cada tipo de frete
				foreach ($tipos as $nome => $valores) {
					// adiciona um Filho para o Xml. nome do tipo de frete
					$tipo = $xml->addChild(strtolower(str_replace(' ','',$nome)));
					// adiciona um filho para o tipo de frete com o nome do tipo
					$tipo->addChild('nome',$nome);
					// laço para acessar os dados do tipo de frete
					foreach ($valores as $key => $value) {
						// adiciona um Filho para o tipo de frete com o dado
						$tipo->addChild($key, $value);
					}
				}
			}
			// seta o Cabeçalho da página para renderização de XML
			$this->getResponse()->setHeader('Content-type','text/xml');
			// envia o XML para camada de visualização
			$this->view->xml = $xml;
		} else { // se o accesso ao serviço não foi por POST
			// lança erro
			throw new F1S_Basket_Freight_FatalErrorException('O acesso à este serviço é somente por POST!');
		}
	}
	
	/**
	 * Método para ordernar fretes por um campo.
	 * Utiliza Quick Sort
	 *
	 * Este método perde as informações de chave do primeiro nível
	 *
	 * @param array $fretes Fretes a serem ordenados
	 * @param string $campo Campo parâmetro de ordenção
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
	 * @param string $campo campo base para verificação
	 * @return array Frete com o menor valor no campo passado
	 */
	protected function _getMenorFretePorCampo($fretes,$campo) {
		$fretes = $this->_ordenaFretesPorCampo($fretes,$campo);
		return array_shift($fretes);
	}

	/**
	 * Ação responsável pela consulta de todos os valores de cada tipo de frete
	 */
	public function consultaAction() {
		// Criação de objeto de XML para geração do retorno
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
			// seta o Cabeçalho da página para renderização de XML
			$this->getResponse()->setHeader('Content-type','text/xml');
			// envia o XML para camada de visualização
				$this->view->xml = $xml;
		} else {
			throw new F1S_Basket_Freight_FatalErrorException('Não existem tipos de frete!');
		}
	}
}

