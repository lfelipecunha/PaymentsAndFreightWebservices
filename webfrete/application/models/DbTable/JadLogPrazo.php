<?php
class Application_Model_DbTable_JadLogPrazo extends Zend_Db_Table_Abstract
{
	protected $_primary = 'id_jadlog_prazo';
	protected $_name = 'webfrete_jadlog_prazo';

	/**
	 * Método que retorna o prazo do frete da JadLog
	 *
	 * @param string $cep_origem  Cep de origem do frete
	 * @param string $cep_destino Cep de destino do frete
	 * @param string $codigo_tipo Código do tipo de frete
	 * @return int Dias de prazo para a entrega
	 */
	public function getPrazo($cep_origem,$cep_destino,$codigo_tipo) {

		// obtem o adaptador de banco de dados para a realização da query
		$adapter = $this->getAdapter();
		// sql a ser executado para obtenção do prazo do frete
		$sql = 
			"SELECT 
				* 
				FROM 
					webfrete_jadlog_prazo 
				WHERE 
					estado = 
						(SELECT 
							sigla 
							FROM 
								webfrete_estado 
							WHERE 
								('$cep_destino' BETWEEN cep_inicio AND cep_fim) OR 
								('$cep_destino' BETWEEN cep_inicio2 AND cep_fim2)
						) 
					AND 
					regiao = IF(
						(SELECT 
							COUNT(*) 
							FROM 
								webfrete_faixa_cep_capital 
							WHERE 
								'$cep_destino' BETWEEN cep_inicio AND cep_fim
						) > 0,
						'CAPITAL',
						'INTERIOR'
					)";

		// executa a query e pega os dados
		$result_prazo = $adapter->query($sql)->fetchAll();

		// objeto de select do adaptador
		$select = $adapter->select();

		// montagem de parametros pra obtenção dos dados tipo de frete
		$select
			->from('webfrete_tipo_frete','cubagem')
			->where('codigo_tipo_frete = ?',$codigo_tipo);
		// executa a query e pega os dados
		$result_tipo = $select->query()->fetchAll();

		// verifica se o prazo a ser enviado é para fretes expressos ou 
		// rodiviários
		if ($result_tipo[0]['cubagem'] == 'AEREO') {
			$result =$result_prazo[0]['prazo_expresso'];
		} else {
			$result =$result_prazo[0]['prazo_rodoviario'];
		}

		// pega o estado do cep de origem
		$select = $adapter->select();
		$estado = $select
			->from('webfrete_estado','sigla')
			->where(
				"('$cep_origem' BETWEEN cep_inicio AND cep_fim) OR
				('$cep_origem' BETWEEN cep_inicio2 AND cep_fim2)")
			->query()
			->fetchAll();

		// array de estado que NÂO devem ser adicionados um dia a mais
		$estados_nao_adicionar_dia = array('SP');

		// se o estado do cep de origem não está no array de estados
		if (!in_array($estado[0]['sigla'],$estados_nao_adicionar_dia)) {
			// adiciona um dia a mais no prazo
			$result += 1;
		}
		return $result;
	}
}
