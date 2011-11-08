<?php

class IndexController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$params = array(
			'cep_origem'     => '02380000',
			'cep_destino'    => '93022000',
			'jadlog_senha'   => 'F2s0C1i1',
			'correios_login' => '',
			'correios_senha' => '',
			'valor_produtos' => '10000',
			'cnpj'           => '09091523000165',
			'produtos'       => array(
				0 => array(
					'altura'      => 10,
					'largura'     => 50,
					'comprimento' => 90,
					'peso'        => 20000,
					'quantidade'  => 10,
				),
				1 => array(
					'altura'      => 60,
					'largura'     => 20,
					'comprimento' => 30,
					'peso'        => 1000,
					'quantidade'  => 10,
				),
				2 => array(
					'altura'      => 10,
					'largura'     => 10,
					'comprimento' => 30,
					'peso'        => 1000,
					'quantidade'  => 6,
				),
			),
			'opcoes'         => array(
				0 => array(
					'codigo' => 1,
					'seguro' => 'N',
					'valor_coleta' => 0,
					'pagar_destino' => 'N',
					'tipo_entrega'  => 'D',
				),
				1 => array(
					'codigo' => 3,
					'formato' => 1,
					'servico_adicional' => 'N',
					'valor_servico_adicional' => '0',
					'aviso_recebimento' => 'N',
				),
				2 => array(
					'codigo' => 2,
					'seguro' => 'N',
					'valor_coleta' => 0,
					'pagar_destino' => 'N',
					'tipo_entrega'  => 'D',
				),
			)
		);




//		if ($this->getRequest()->isPost) {
//			$params = $this->getRequest()->getPost();
	 		$validate = new Application_Model_Validate($params);
			$params = $validate->validaParams();

			$tipo_frete = new Application_Model_DbTable_TipoFrete();

			$fretes = array();
			foreach ($params['opcoes'] as $opcao) {
				$dados = $tipo_frete->getById($opcao['codigo']);
				$grupo = $dados[0]['nome_grupo'];
				$nome = $dados[0]['nome_tipo_frete'];
				try {
					$filtro = new Zend_Filter_Word_UnderscoreToCamelCase();
					$nome_classe = $filtro->filter($grupo);
					$reflection = new Zend_Reflection_Class('Application_Model_'.$nome_classe);
					$opcao['codigo_tipo_frete'] = $dados[0]['codigo_tipo_frete'];
					$model = $reflection->newInstance($params,$opcao);
					$fretes[$grupo][$nome] = $model->consulta();
				} catch (Zend_Exception_Frete $e) {
					throw $e;
				} catch (Exception $e) {
					$fretes[$grupo][$nome]['erro'] = $e->getCode();
				}
			}

			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><consulta></consulta>');
			foreach ($fretes as $tipos) {
				foreach ($tipos as $nome => $valores) {
					$tipo = $xml->addChild(strtolower($nome));
					$tipo->addChild('nome',$nome);
					foreach ($valores as $key => $value) {
						$tipo->addChild($key, $value);
					}
				}
			}
			$this->getResponse()->setHeader('Content-type','text/xml');
			$this->view->xml = $xml;
//		}else {
//			throw new Zend_Exception_Frete('O acesso à este serviço é somente por POST!');
//		}
	}

	public static function teste() {
		throw new ErrorException('oi');
	}


}

