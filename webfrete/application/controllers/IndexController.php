<?php

class IndexController extends Zend_Controller_Action
{

	/**
	 * Ação responsável pela realização de consultas de valor e prazo de fretes
	 */
	public function indexAction()
	{
		//a;
		// verifica se o houve envio de dados por POST
		if ($this->getRequest()->isPost) { // se houve envio
			// pega os dados do POST
			$params = $this->getRequest()->getPost();
			// instância do Modelo de validação de dados padrões
			$validate = new Application_Model_Validate($params);
			// pega os dados validados. Neste ponto podem ser lançadas exceções
			$params = $validate->validaParams();

			// instância do objeto de Tabela de Tipo de Frete
			$tipo_frete = new Application_Model_DbTable_TipoFrete();
			// inicialização de array dos tipos de fretes
			$fretes = array();
			// laço para obtenção dos valores e prazos de frete para cada opcao
			// passada por parâmetro
			foreach ($params['opcoes'] as $opcao) {
				// pega os dados do tipo de frete de acordo com o código do tipo
				$dados = $tipo_frete->getById($opcao['codigo']);
				// grupo do tipo de frete. Utilizado para definir qual classe de 
				// modelo será utilizada
				$grupo = $dados[0]['nome_grupo'];

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
					// armazena os dados do frete no array de fretes
					$fretes[$grupo][$nome] = $model->consulta();

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

			// Criação de objeto de XML para geração do retorno
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><consulta></consulta>');
			// laço para inserção dos tipos de frete no xml
			foreach ($fretes as $tipos) {
				// laço para cada tipo de frete
				foreach ($tipos as $nome => $valores) {
					// adiciona um Filho para o Xml. nome do tipo de frete
					$tipo = $xml->addChild(strtolower($nome));
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
		}else { // se o accesso ao serviço não foi por POST
			// lança erro
			throw new F1S_Basket_Freight_FatalErrorException('O acesso à este serviço é somente por POST!');
		}
	}
}

