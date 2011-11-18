<?php
class Application_Model_DbTable_TabelaContingencia extends Zend_Db_Table_Abstract
{
	protected $_name = 'webfrete_tabela_contingencia';

	protected $_primary = 'id';

	public function getValuesByTipoFreteCode($code,$cep_destino) {
		$select = $this->getAdapter()->select();
		$select
			->from(array('tc' => $this->info(self::NAME)),array('valor','prazo'))
			->join(array('e' => 'webfrete_estado'),'tc.estado = e.sigla','')
			->join(array('tf' => 'webfrete_tipo_frete'),'tc.tipo_frete = tf.id_tipo_frete','')
			->where('(? BETWEEN e.cep_inicio AND e.cep_fim) OR (? BETWEEN e.cep_inicio2 AND e.cep_fim2)',$cep_destino)
			->where('tf.codigo_tipo_frete = ?',$code);
		return $select->query()->fetchAll();
	}
}
