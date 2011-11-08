<?php
class Application_Model_DbTable_GrupoTipoFrete extends Zend_Db_Table_Abstract
{
	protected $_name = 'webfrete_grupo_tipo_frete';
	protected $_primary = 'id_grupo';
	protected $_dependentTables = array('TipoFrete');
}