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

	public function getAllTypesWithParams() {
		$parametros = new Application_Model_DbTable_Parametro();
		$grupo = new Application_Model_DbTable_GrupoTipoFrete();
		$select = $this->getAdapter()->select();
		$select
			->from(
				array('t' => $this->info(self::NAME)),
				array('codigo_tipo_frete','nome_tipo_frete','id_tipo_frete')
			)
			->joinLeft(
				array('g' => $grupo->info(self::NAME)),
				'g.id_grupo = t.id_grupo_tipo_frete',
				array('nome_grupo')
			)
			->joinLeft(
				array('thp' => 'webfrete_tipo_frete_has_parametro'),
				'thp.id_tipo_frete = t.id_tipo_frete',
				''
			)
			->joinLeft(
				array('p' => $parametros->info(self::NAME)),
				'thp.id_parametro = p.id_parametro',
				'nome_parametro'
			)
			->where('p.tipo_parametro = \'ESTATICO\'');
		return $select->query()->fetchAll();
	}
}
