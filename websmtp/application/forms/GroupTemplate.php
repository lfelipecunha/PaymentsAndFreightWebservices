<?php

class Application_Form_GroupTemplate extends Zend_Form
{
	public function init() {
		$this->setDecorators(array('FormElements'));
		$name = new Zend_Form_Element('name_group_template');
		$name
			->setRequired()
			->setLabel('*Nome:')
			->setAllowEmpty(false);
		$this->addElement($name);

		$identifier = new Zend_Form_Element('identifier_group_template');
		$identifier
			->setRequired()
			->setLabel('*Identificador:')
			->setAllowEmpty(false);
		$this->addElement($identifier);

		$status = new Zend_Form_Element_Radio('status_group_template');
		$status
			->addMultiOptions(array('enable' => 'Ativo','disable' => 'Inativo'))
			->setLabel('*Status')
			->setValue('enable');
		$this->addElement($status);

		$this->addSubForm(new Application_Form_SubFormTemplate,0);

		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setLabel('Cancelar');
		$this->addElement($cancel);


		$submit = new Zend_Form_Element_Submit('save');
		$submit->setLabel('Salvar');
		$this->addElement($submit);
	}
}
