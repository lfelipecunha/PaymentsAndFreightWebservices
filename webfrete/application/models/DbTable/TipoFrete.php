<?php
class Application_Model_DbTable_TipoFrete extends Zend_Db_Table_Abstract
{
	protected $_name = 'webfrete_tipo_frete';
	protected $_primary = 'id_tipo_frete';

	protected $_referenceMap = array(
		'Grupo' => array(
			'columns'       => 'id_grupo_tipo_frete',
			'refTableClass' => 'Application_Model_DbTable_GrupoTipoFrete',
			'refColumns'    => 'id_grupo'
		)
	);

	public function getById($id) {
		$table = new Application_Model_DbTable_GrupoTipoFrete();
		$adapter = $this->getAdapter();
		$select = $adapter->select();
		$select
			->from(array('t' => $this->info(self::NAME)), array('id_tipo_frete','nome_tipo_frete','codigo_tipo_frete'), $this->info(self::SCHEMA))
			->joinLeft(array('g' => $table->info(self::NAME)), 't.id_grupo_tipo_frete = g.id_grupo', 'g.nome_grupo', $table->info(self::SCHEMA))
			->where('t.id_tipo_frete = ?', $id)
			->limit(1);
		return $select->query()->fetchAll();
	}
}