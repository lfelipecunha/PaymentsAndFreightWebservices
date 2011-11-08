<?php
class Application_Form_Produto extends Zend_Form
{
	public function init() {
		parent::init();

		$altura = new Zend_Form_Element('altura');
		$altura
			->addValidator(new Zend_Validate_Digits())
			->setRequired();
		$this->addElement($altura);

		$largura = new Zend_Form_Element('largura');
		$largura
			->addValidator(new Zend_Validate_Digits())
			->setRequired();
		$this->addElement($largura);

		$comprimento = new Zend_Form_Element('comprimento');
		$comprimento
			->addValidator(new Zend_Validate_Digits())
			->setRequired();
		$this->addElement($comprimento);

		$peso = new Zend_Form_Element('peso');
		$peso
			->addValidator(new Zend_Validate_Digits())
			->setRequired();
		$this->addElement($peso);

		$quantidade = new Zend_Form_Element('quantidade');
		$quantidade
			->addValidator(new Zend_Validate_Digits())
			->setRequired();
		$this->addElement($quantidade);
	}
}
