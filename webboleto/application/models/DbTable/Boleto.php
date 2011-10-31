<?php
class Application_Model_DbTable_Boleto extends Zend_Db_Table_Abstract
{
	protected $_name = 'boleto';

	protected $_primary = array('codigo');

	public function getParams($codigo_boleto, $statics = false) {
		$db = $this->getAdapter();
		$params = $db
			->select()
			->from(array('b' => 'boleto'),array())
			->where("b.codigo = '$codigo_boleto'");
		if ($statics) {
			$params->where('p.tipo_parametro = \'ESTATICO\'');
		}
		$params
			->joinLeft(array('bhp' => 'boleto_has_parametro'),'b.codigo = bhp.codigo',array())
			->joinLeft(array('p' => 'parametro'),'p.id_parametro = bhp.id_parametro',array('nome_parametro'));
		return $db->fetchCol($params);
	}

	public function getBoletosDisponiveis() {
		$select =  $this->select()->from($this,'codigo');
		return $this->getAdapter()->fetchCol($select);
	}

}
