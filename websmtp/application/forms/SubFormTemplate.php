<?php

class Application_Form_SubFormTemplate extends Zend_Form
{
	public function init() {
		$this->setDecorators(array('FormElements'));
		$name = new Zend_Form_Element('name_template');
		$name
			->setRequired()
			->setLabel('*Nome template:')
			->setAllowEmpty(false);
		$this->addElement($name);

		$identifier = new Zend_Form_Element('identifier_template');
		$identifier
			->setRequired()
			->setLabel('*Identificador:')
			->setAllowEmpty(false);
		$this->addElement($identifier);

		$status = new Zend_Form_Element_Radio('status_template');
		$status
			->addMultiOptions(array('enable' => 'Ativo','disable' => 'Inativo'))
			->setLabel('*Status')
			->setValue('enable');
		$this->addElement($status);

		$template = new Zend_Form_Element_Textarea('template');
		$template
			->setRequired()
			->setAllowEmpty(false)
			->setLabel('*Template');
		$this->addElement($template);

		$variaveis = new Zend_Form_Element_Textarea('vars');
		$variaveis
			->setRequired()
			->setAllowEmpty(false)
			->setLabel('*Variáveis');
		$this->addElement($variaveis);
	}
}

