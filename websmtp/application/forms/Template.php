<?php

class Application_Form_Template extends Zend_Form
{
	public function init() {
		$name = new Zend_Form_Element('name');
		$name
			->setRequired()
			->setAllowEmpty(false);
		$this->addElement($name);

		$identifier = new Zend_Form_Element('identifier');
		$identifier
			->setRequired()
			->setAllowEmpty(false);
		$this->addElement($identifier);

		$status = new Zend_Form_Element_Radio('status');
		$status
			->addMultiOptions(array('enable' => 'Ativo','disable' => 'Inativo'))
			->setLabel('*Status')
			->setValue('enable');
		$this->addElement($status);
	}
}

