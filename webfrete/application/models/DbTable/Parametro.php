<?php
class Application_Model_DbTable_Parametro extends Zend_Db_Table_Abstract
{
	protected $_name = 'webfrete_parametro';
	protected $_primary = 'id_parametro';

	public function getParametrosByIdTipo($id) {
		$adapter = $this->getAdapter();
		$select = $adapter->select();
		$select
			->from(array('p' => $this->info(self::NAME)),'p.*')
			->joinLeft(array('thp' => 'webfrete_tipo_frete_has_parametro'),'thp.id_parametro = p.id_parametro')
			->where('thp.id_tipo_frete = ?',$id);
		return $select->query()->fetchAll();
	}
}
