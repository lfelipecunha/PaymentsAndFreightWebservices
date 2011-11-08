<?php
class Application_Form_Correios extends Zend_Form
{
	public function init(){
		parent::init();

		$formato = new Zend_Form_Element('formato');
		$formato
			->addValidator(new Zend_Validate_InArray(array('1','2')))
			->setRequired();
		$this->addElement($formato);

		$servico_adicional = new Zend_Form_Element('servico_adicional');
		$servico_adicional
			->addValidator(new Zend_Validate_InArray(array('S','N')))
			->setRequired();
		$this->addElement($servico_adicional);

		$valor_servico_adicional = new Zend_Form_Element('valor_servico_adicional');
		$valor_servico_adicional
			->addValidator(new Zend_Validate_Digits())
			->setRequired();
		$this->addElement($valor_servico_adicional);

		$aviso_recebimento = new Zend_Form_Element('aviso_recebimento');
		$aviso_recebimento
			->addValidator(new Zend_Validate_InArray(array('S','N')))
			->setRequired();
		$this->addElement($aviso_recebimento);

		$valor_produtos = new Zend_Form_Element('valor_produtos');
		$valor_produtos
			->addValidator(new Zend_Validate_Digits())
			->setRequired();
		$this->addElement($valor_produtos);
	}
}