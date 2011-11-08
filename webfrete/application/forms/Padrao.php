<?php
class Application_Form_Padrao extends Zend_Form {
	public function init() {
		parent::init();
		$cep_origem = new Zend_Form_Element('cep_origem');
		$cep_origem
			->addValidator(new Zend_Validate_Digits())
			->addValidator(new Zend_Validate_StringLength(8,8))
			->setRequired(true);
		$this->addElement($cep_origem);

		$cep_destino = new Zend_Form_Element('cep_destino');
		$cep_destino
			->addValidator(new Zend_Validate_Digits())
			->addValidator(new Zend_Validate_StringLength(8,8))
			->setRequired(true);
		$this->addElement($cep_destino);

		$correios_login = new Zend_Form_Element('correios_login');
		$correios_login
			->setAllowEmpty(true)
			->setRequired(false);
		$this->addElement($correios_login);

		$correios_senha = new Zend_Form_Element('correios_senha');
		$correios_senha
			->setAllowEmpty(true)
			->setRequired(false);
		$this->addElement($correios_senha);

		$jadlog_login = new Zend_Form_Element('jadlog_login');
		$jadlog_login
			->setAllowEmpty(true)
			->setRequired(false);
		$this->addElement($jadlog_login);

		$jadlog_senha = new Zend_Form_Element('jadlog_senha');
		$jadlog_senha
			->setAllowEmpty(true)
			->setRequired(false);
		$this->addElement($jadlog_senha);

		$cnpj = new Zend_Form_Element('cnpj');
		$cnpj
			->setAllowEmpty(true)
			->setRequired(false);
		$this->addElement($cnpj);

		$produtos = new Zend_Form_Element('produtos');
		$produtos
			->setAllowEmpty(false)
			->setRequired(true);
		$this->addElement($produtos);

		$valor_produtos = new Zend_Form_Element('valor_produtos');
		$valor_produtos
			->setAllowEmpty(true)
			->setRequired(false);
		$this->addElement($valor_produtos);

		$opcoes = new Zend_Form_Element('opcoes');
		$opcoes
			->setAllowEmpty(false)
			->setRequired(true);
		$this->addElement($opcoes);
	}
}