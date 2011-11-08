<?php
class Application_Form_JadLogConsulta extends Zend_Form
{
	public function init(){
		parent::init();
		$modalidade = new Zend_Form_Element('codigo_tipo_frete');
		$modalidade
			->addValidator(new Zend_Validate_Digits())
			->setRequired(true);
		$this->addElement($modalidade);

		$tipo_seguro = new Zend_Form_Element('seguro');
		$tipo_seguro
			->addValidator(new Zend_Validate_InArray(array('A','N')))
			->setRequired(true);
		$this->addElement($tipo_seguro);

		$valor_coleta = new Zend_Form_Element('valor_coleta');
		$valor_coleta
			->addValidator(new Zend_Validate_Digits())
			->setRequired(true);
		$this->addElement($valor_coleta);

		$frete_pagar = new Zend_Form_Element('pagar_destino');
		$frete_pagar
			->addValidator(new Zend_Validate_InArray(array('S','N')))
			->setRequired(true);
		$this->addElement($frete_pagar);

		$tipo_entrega = new Zend_Form_Element('tipo_entrega');
		$tipo_entrega
			->addValidator(new Zend_Validate_InArray(array('R','D')))
			->setRequired(true);
		$this->addElement($tipo_entrega);

		$jadlog_login = new Zend_Form_Element('jadlog_login');
		$jadlog_login
			->setRequired();
		//$this->addElement($jadlog_login);

		$jadlog_senha = new Zend_Form_Element('jadlog_senha');
		$jadlog_senha
			->setRequired();
		$this->addElement($jadlog_senha);

		$cnpj = new Zend_Form_Element('cnpj');
		$cnpj
			->addValidator(new Zend_Validate_Digits())
			->setRequired();
		$this->addElement($cnpj);

		$valor_produtos = new Zend_Form_Element('valor_produtos');
		$valor_produtos
			->addValidator(new Zend_Validate_Digits())
			->setRequired();
		$this->addElement($valor_produtos);
	}
}