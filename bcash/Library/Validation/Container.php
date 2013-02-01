<?php

class Validation_Container {

    protected $_name;

    private $_elements = array();

    private $_subContainers = array();

    protected $_invalidFields = array();

    public function __construct() {
        $this->init();
    }

    public function init(){}

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = (string)$name;
    }

    public function addSubContainer(Validation_Container $validator,$name) {
        $name = (string)$name;
        if ($name === '') {
            throw new Exception('Invalid Name!');
        }
        $validator->setName($name);
        $this->_subContainers[$name] = $validator;
        return $this;
    }

    public function addElement(Validation_Element $element) {
        $this->_elements[] = $element;
        return $this;
    }

    public function getElements() {
        return $this->_elements;
    }

    public function isValid($data) {
        $validatorName = $this->getName();
        if (!empty($validatorName)) {
            $data = (array)@$data[$validatorName];
        }
        $isValid = true;
        foreach ($this->getElements() as $element) {
            $elementName = $element->getName();
            $element->setValue(@$data[$elementName]);
            if (!$element->isValid()) {
                $this->_invalidFields[$elementName] = $element->getErrors();
                $isValid = false;
            }
        }
        foreach ($this->_subContainers as $container) {
            $containerName = $container->getName();
            if (!$container->isValid(array($containerName => @$data[$containerName]))) {
                $this->_invalidFields[$containerName] = $container->getInvalidFields();
                $isValid = false;
            }
        }
        return $isValid;
    }

    public function getInvalidFields() {
        return $this->_invalidFields;
    }

    public function getValues() {
        $result = array();
        foreach ($this->getElements() as $element) {
            $result[$element->getName()] = $element->getValue();
        }

        foreach ($this->_subContainers as $container) {
            $result[$container->getName()] = $container->getValues();
        }
        return $result;
    }
}
