<?php
class Application_Model_Validate
{
	protected $_params;

	public function __construct($params) {
		$this->_params = $params;
	}

	public function validaParams() {
		$form_padrao = new Application_Form_Padrao();
		$result = array();
		if ($form_padrao->isValid($this->_params)) {
			$params = $form_padrao->getValues();
			if (!is_array($params['produtos'])) {
				throw new F1S_Basket_Freight_FatalErrorException(array('produtos' => array('invalidFormat' => 'O parâmetro deve ser passado como array!')));
			}
			if (!is_array($params['opcoes'])) {
				throw new F1S_Basket_Freight_FatalErrorException(array('opcoes' => array('invalidFormat' => 'O parâmetro deve ser passado como array!')));
			}

			$form_produto = new Application_Form_Produto();
			foreach ($params['produtos'] as $produto) {
				if ($form_produto->isValid($produto)) {
					$result['produtos'][] = $form_produto->getValues();
				} else {
					throw new F1S_Basket_Freight_FatalErrorException($form_produto->getMessages());
				}
			}

			$tipo_frete = new Application_Model_DbTable_TipoFrete();
			foreach ($params['opcoes'] as $opcao) {
				if (empty($opcao['codigo'])) {
					throw new F1S_Basket_Freight_FatalErrorException(array('opcoes' => array('isEmpty' => 'Código do tipo de frete deve ser informado!')));
				}
				$dados = $tipo_frete->getById($opcao['codigo']);
				if (empty($dados)) {
					throw new F1S_Basket_Freight_FatalErrorException(array('opcoes' => array('invalidCode' => 'Código do tipo de frete informado é inválido!')));
				}
			}
			$result = array_merge($result,$params);
		} else {
			throw new F1S_Basket_Freight_FatalErrorException($form_padrao->getMessages());
		}
		return $result;
	}
}
