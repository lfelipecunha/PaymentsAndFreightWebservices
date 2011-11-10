<?php

class IndexController extends Zend_Controller_Action
{

	/**
	 * A��o respons�vel pela realiza��o de consultas de valor e prazo de fretes
	 */
	public function indexAction()
	{
		//a;
		// verifica se o houve envio de dados por POST
		if ($this->getRequest()->isPost) { // se houve envio
			// pega os dados do POST
			$params = $this->getRequest()->getPost();
			// inst�ncia do Modelo de valida��o de dados padr�es
			$validate = new Application_Model_Validate($params);
			// pega os dados validados. Neste ponto podem ser lan�adas exce��es
			$params = $validate->validaParams();

			// inst�ncia do objeto de Tabela de Tipo de Frete
			$tipo_frete = new Application_Model_DbTable_TipoFrete();
			// inicializa��o de array dos tipos de fretes
			$fretes = array();
			// la�o para obten��o dos valores e prazos de frete para cada opcao
			// passada por par�metro
			foreach ($params['opcoes'] as $opcao) {
				// pega os dados do tipo de frete de acordo com o c�digo do tipo
				$dados = $tipo_frete->getById($opcao['codigo']);
				// grupo do tipo de frete. Utilizado para definir qual classe de 
				// modelo ser� utilizada
				$grupo = $dados[0]['nome_grupo'];

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
					// armazena os dados do frete no array de fretes
					$fretes[$grupo][$nome] = $model->consulta();

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

			// Cria��o de objeto de XML para gera��o do retorno
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><consulta></consulta>');
			// la�o para inser��o dos tipos de frete no xml
			foreach ($fretes as $tipos) {
				// la�o para cada tipo de frete
				foreach ($tipos as $nome => $valores) {
					// adiciona um Filho para o Xml. nome do tipo de frete
					$tipo = $xml->addChild(strtolower($nome));
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
		}else { // se o accesso ao servi�o n�o foi por POST
			// lan�a erro
			throw new F1S_Basket_Freight_FatalErrorException('O acesso � este servi�o � somente por POST!');
		}
	}
}

