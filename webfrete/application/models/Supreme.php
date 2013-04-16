<?php

class Application_Model_Supreme implements Application_Model_Frete
{
	private $_params = null;

	private function _getFaixas() {
		return array (
			'Rondonia - Estado' =>
			array (
				'ini' => '76800000',
				'end' => '76999999',
				'opcoes' =>
				array (
					10 => 49,
					20 => 85,
					30 => 200,
					50 => 250,
					100 => 400,
				),
				'prazo' => 9,
			),
			'Rondonia - Guajara-Mirim' =>
			array (
				'ini' => '76850000',
				'end' => '76850000',
				'opcoes' =>
				array (
					10 => 52,
					20 => 84,
					30 => 300,
					50 => 350,
					100 => 500,
				),
				'prazo' => 14,
			),
			'Bahia - Capital' =>
			array (
				'ini' => '40000001',
				'end' => '42499999',
				'opcoes' =>
				array (
					10 => 37,
					20 => 51,
					30 => 60,
					50 => 75,
					100 => 115,
				),
				'prazo' => 6,
			),
			'Bahia - Interior' =>
			array (
				'ini' => '42500000',
				'end' => '48999999',
				'opcoes' =>
				array (
					10 => 60,
					20 => 75,
					30 => 95,
					50 => 125,
					100 => 300,
				),
				'prazo' => 10,
			),
			'Tocantins - Capital' =>
			array (
				'ini' => '77000001',
				'end' => '77249999',
				'opcoes' =>
				array (
					10 => 34,
					20 => 65,
					30 => 75,
					50 => 114,
					100 => 185,
				),
				'prazo' => 7,
			),
			'Tocantins - Interior 1' =>
			array (
				'ini' => '77250000',
				'end' => '77999999',
				'opcoes' =>
				array (
					10 => 59,
					20 => 77,
					30 => 96,
					50 => 174,
					100 => 224,
				),
				'prazo' => 11,
			),
			'Tocantins - Interior Norte' =>
			array (
				'ini' => '77250000',
				'end' => '77999100',
				'opcoes' =>
				array (
					10 => 85,
					20 => 93,
					30 => 112,
					50 => 126,
					100 => 247,
				),
				'prazo' => 11,
			),
			'Goias - Capital / Aparecida' =>
			array (
				'ini' => '74000001',
				'end' => '74899999',
				'opcoes' =>
				array (
					10 => 36,
					20 => 45,
					30 => 66,
					50 => 80,
					100 => 112,
				),
				'prazo' => 5,
			),
			'Goias - Interior' =>
			array (
				'ini' => '73700000',
				'end' => '76799999',
				'opcoes' =>
				array (
					10 => 48,
					20 => 56,
					30 => 83,
					50 => 114,
					100 => 184,
				),
				'prazo' => 8,
			),
			'Distrito Federal - Capital / Metropolis' =>
			array (
				'ini' => '70000001',
				'end' => '72799999',
				'opcoes' =>
				array (
					10 => 36,
					20 => 45,
					30 => 67,
					50 => 82,
					100 => 112,
				),
				'prazo' => 5,
			),
			'Distrito Federal - Interior' =>
			array (
				'ini' => '73000000',
				'end' => '73699999',
				'opcoes' =>
				array (
					10 => 45,
					20 => 53,
					30 => 70,
					50 => 90,
					100 => 136,
				),
				'prazo' => 5,
			),
			'Mato Grosso - Capital / Varzea Grande' =>
			array (
				'ini' => '78000001',
				'end' => '78099999',
				'opcoes' =>
				array (
					10 => 75,
					20 => 45,
					30 => 66,
					50 => 78,
					100 => 158,
				),
				'prazo' => 6,
			),
			'Mato Grosso - Interior' =>
			array (
				'ini' => '78000000',
				'end' => '78899999',
				'opcoes' =>
				array (
					10 => 63,
					20 => 77,
					30 => 109,
					50 => 178,
					100 => 195,
				),
				'prazo' => 12,
			),
			'Amapá - Capital' =>
			array (
				'ini' => '68900001',
				'end' => '68911999',
				'opcoes' =>
				array (
					10 => 89,
					20 => 107,
					30 => 145,
					50 => 195,
					100 => 278,
				),
				'prazo' => 12,
			),
			'Amapá - Interior' =>
			array (
				'ini' => '68912000',
				'end' => '68999999',
				'opcoes' =>
				array (
					10 => 89,
					20 => 107,
					30 => 145,
					50 => 195,
					100 => 278,
				),
				'prazo' => 15,
			),
			'Amazonas - Capital' =>
			array (
				'ini' => '69000001',
				'end' => '69099999',
				'opcoes' =>
				array (
					10 => 105,
					20 => 225,
					30 => 295,
					50 => 301,
					100 => 397,
				),
				'prazo' => 15,
			),
			'Amazonas - ZN/INT' =>
			array (
				'ini' => '69100000',
				'end' => '69299999',
				'opcoes' =>
				array (
					10 => 226,
					20 => 301,
					30 => 375,
					50 => 408,
					100 => 527,
				),
				'prazo' => 22,
			),
			'Mato Grosso Sul - Capital' =>
			array (
				'ini' => '79000001',
				'end' => '79124999',
				'opcoes' =>
				array (
					10 => 53,
					20 => 42,
					30 => 61,
					50 => 88,
					100 => 128,
				),
				'prazo' => 5,
			),
			'Mato Grosso Sul - Interior' =>
			array (
				'ini' => '79125999',
				'end' => '79999999',
				'opcoes' =>
				array (
					10 => 56,
					20 => 68,
					30 => 96,
					50 => 134,
					100 => 168,
				),
				'prazo' => 8,
			),
			'Minas Gerais - Capital' =>
			array (
				'ini' => '30000001',
				'end' => '31999999',
				'opcoes' =>
				array (
					10 => 35,
					20 => 43,
					30 => 62,
					50 => 82,
					100 => 112,
				),
				'prazo' => 5,
			),
			'Minas Gerais - Interior' =>
			array (
				'ini' => '32000000',
				'end' => '39999100',
				'opcoes' =>
				array (
					10 => 50,
					20 => 57,
					30 => 74,
					50 => 89,
					100 => 116,
				),
				'prazo' => 7,
			),
			'Roraima - Capital' =>
			array (
				'ini' => '76800001',
				'end' => '76834999',
				'opcoes' =>
				array (
					10 => 74,
					20 => 101,
					30 => 124,
					50 => 198,
					100 => 204,
				),
				'prazo' => 10,
			),
			'Roraima - Interior' =>
			array (
				'ini' => '76835000',
				'end' => '76999999',
				'opcoes' =>
				array (
					10 => 87,
					20 => 127,
					30 => 168,
					50 => 247,
					100 => 289,
				),
				'prazo' => 14,
			),
			'Espírito Santo - Capital' =>
			array (
				'ini' => '29000001',
				'end' => '29099999',
				'opcoes' =>
				array (
					10 => 37,
					20 => 46,
					30 => 69,
					50 => 79,
					100 => 102,
				),
				'prazo' => 5,
			),
			'Espírito Santo - Metropolitana' =>
			array (
				'ini' => '29099999',
				'end' => '29999999',
				'opcoes' =>
				array (
					10 => 39,
					20 => 48,
					30 => 72,
					50 => 84,
					100 => 107,
				),
				'prazo' => 5,
			),
			'Espírito Santo - Metropolitana 1' =>
			array (
				'ini' => '29099999',
				'end' => '29999100',
				'opcoes' =>
				array (
					10 => 51,
					20 => 63,
					30 => 93,
					50 => 102,
					100 => 124,
				),
				'prazo' => 5,
			),
			'Espírito Santo - Interior' =>
			array (
				'ini' => '29099999',
				'end' => '29999100',
				'opcoes' =>
				array (
					10 => 59,
					20 => 71,
					30 => 104,
					50 => 127,
					100 => 156,
				),
				'prazo' => 7,
			),
			'São Paulo - Capital' =>
			array (
				'ini' => '01000001',
				'end' => '05999999',
				'opcoes' =>
				array (
					10 => 36,
					20 => 40,
					30 => 56,
					50 => 64,
					100 => 77,
				),
				'prazo' => 3,
			),
			'São Paulo - Capital *' =>
			array (
				'ini' => '08000000',
				'end' => '08499999',
				'opcoes' =>
				array (
					10 => 36,
					20 => 40,
					30 => 56,
					50 => 64,
					100 => 77,
				),
				'prazo' => 3,
			),
			'São Paulo - Metropolitana**' =>
			array (
				'ini' => '08500000',
				'end' => '19999999',
				'opcoes' =>
				array (
					10 => 39,
					20 => 42,
					30 => 59,
					50 => 68,
					100 => 87,
				),
				'prazo' => 4,
			),
			'São Paulo - Bauru/RibP/SJRP/Campinas/Franca' =>
			array (
				'ini' => '08500000',
				'end' => '19999100',
				'opcoes' =>
				array (
					10 => 38,
					20 => 45,
					30 => 64,
					50 => 72,
					100 => 91,
				),
				'prazo' => 5,
			),
			'São Paulo - Int. reg Bauru/RP/SJP/Camp/Fca' =>
			array (
				'ini' => '08500000',
				'end' => '19999100',
				'opcoes' =>
				array (
					10 => 58,
					20 => 64,
					30 => 95,
					50 => 105,
					100 => 132,
				),
				'prazo' => 5,
			),
			'São Paulo - Interior' =>
			array (
				'ini' => '08500000',
				'end' => '19999100',
				'opcoes' =>
				array (
					10 => 60,
					20 => 69,
					30 => 99,
					50 => 111,
					100 => 141,
				),
				'prazo' => 6,
			),
			'Rio de Janeiro - Capital' =>
			array (
				'ini' => '20000001',
				'end' => '23799999',
				'opcoes' =>
				array (
					10 => 38,
					20 => 43,
					30 => 62,
					50 => 75,
					100 => 82,
				),
				'prazo' => 5,
			),
			'Rio de Janeiro - Metropolitana**' =>
			array (
				'ini' => '23799999',
				'end' => '28999999',
				'opcoes' =>
				array (
					10 => 41,
					20 => 45,
					30 => 65,
					50 => 77,
					100 => 86,
				),
				'prazo' => 5,
			),
			'Rio de Janeiro - Interior' =>
			array (
				'ini' => '23799999',
				'end' => '28999100',
				'opcoes' =>
				array (
					10 => 47,
					20 => 52,
					30 => 71,
					50 => 81,
					100 => 100,
				),
				'prazo' => 6,
			),
			'Paraná - Capital' =>
			array (
				'ini' => '80000001',
				'end' => '82999999',
				'opcoes' =>
				array (
					10 => 20,
					20 => 0,
					30 => 0,
					50 => 0,
					100 => 0,
				),
				'prazo' => 2,
			),
			'Paraná - Metropolitana**' =>
			array (
				'ini' => '82999999',
				'end' => '87999999',
				'opcoes' =>
				array (
					10 => 33,
					20 => 39,
					30 => 53,
					50 => 61,
					100 => 78,
				),
				'prazo' => 4,
			),
			'Paraná - Reg. Maringá/Cvel/Ldna' =>
			array (
				'ini' => '82999999',
				'end' => '87999100',
				'opcoes' =>
				array (
					10 => 54,
					20 => 60,
					30 => 78,
					50 => 81,
					100 => 98,
				),
				'prazo' => 4,
			),
			'Paraná - Interior' =>
			array (
				'ini' => '82999999',
				'end' => '87999100',
				'opcoes' =>
				array (
					10 => 49,
					20 => 58,
					30 => 78,
					50 => 80,
					100 => 98,
				),
				'prazo' => 5,
			),
			'Santa Catarina - Reg Blumenau/Joinville/Jaraguá' =>
			array (
				'ini' => '88000001',
				'end' => '88099999',
				'opcoes' =>
				array (
					10 => 31,
					20 => 36,
					30 => 49,
					50 => 55,
					100 => 68,
				),
				'prazo' => 4,
			),
			'Santa Catarina - Litoral/Vale Itajaí' =>
			array (
				'ini' => '88099999',
				'end' => '89999999',
				'opcoes' =>
				array (
					10 => 37,
					20 => 43,
					30 => 59,
					50 => 74,
					100 => 90,
				),
				'prazo' => 5,
			),
			'Santa Catarina - Oeste' =>
			array (
				'ini' => '88099999',
				'end' => '89999100',
				'opcoes' =>
				array (
					10 => 38,
					20 => 45,
					30 => 61,
					50 => 76,
					100 => 91,
				),
				'prazo' => 5,
			),
			'Santa Catarina - Interior 1 ( Rio do Sul)' =>
			array (
				'ini' => '88099999',
				'end' => '89999100',
				'opcoes' =>
				array (
					10 => 44,
					20 => 52,
					30 => 71,
					50 => 78,
					100 => 92,
				),
				'prazo' => 5,
			),
			'Santa Catarina - Interior São Bento Sul' =>
			array (
				'ini' => '88099999',
				'end' => '89999100',
				'opcoes' =>
				array (
					10 => 50,
					20 => 60,
					30 => 85,
					50 => 98,
					100 => 127,
				),
				'prazo' => 5,
			),
			'Ceará - Capital' =>
			array (
				'ini' => '60000001',
				'end' => '61599999',
				'opcoes' =>
				array (
					10 => 76,
					20 => 86,
					30 => 101,
					50 => 157,
					100 => 254,
				),
				'prazo' => 8,
			),
			'Ceará - Interior' =>
			array (
				'ini' => '61599999',
				'end' => '63999999',
				'opcoes' =>
				array (
					10 => 89,
					20 => 102,
					30 => 168,
					50 => 214,
					100 => 298,
				),
				'prazo' => 12,
			),
			'Pernambuco - Capital' =>
			array (
				'ini' => '50000001',
				'end' => '52999999',
				'opcoes' =>
				array (
					10 => 72,
					20 => 84,
					30 => 115,
					50 => 159,
					100 => 227,
				),
				'prazo' => 7,
			),
			'Pernambuco - Interior' =>
			array (
				'ini' => '52999999',
				'end' => '56999999',
				'opcoes' =>
				array (
					10 => 79,
					20 => 91,
					30 => 112,
					50 => 174,
					100 => 238,
				),
				'prazo' => 11,
			),
			'Rio Grande do Norte - Capital' =>
			array (
				'ini' => '59000001',
				'end' => '59139999',
				'opcoes' =>
				array (
					10 => 86,
					20 => 92,
					30 => 114,
					50 => 182,
					100 => 273,
				),
				'prazo' => 8,
			),
			'Rio Grande do Norte - Interior' =>
			array (
				'ini' => '59139999',
				'end' => '59999999',
				'opcoes' =>
				array (
					10 => 95,
					20 => 102,
					30 => 148,
					50 => 197,
					100 => 284,
				),
				'prazo' => 12,
			),
			'Alagoas - Capital' =>
			array (
				'ini' => '57000001',
				'end' => '57099999',
				'opcoes' =>
				array (
					10 => 89,
					20 => 97,
					30 => 113,
					50 => 184,
					100 => 224,
				),
				'prazo' => 8,
			),
			'Alagoas - Interior' =>
			array (
				'ini' => '57099999',
				'end' => '57999999',
				'opcoes' =>
				array (
					10 => 91,
					20 => 101,
					30 => 126,
					50 => 172,
					100 => 201,
				),
				'prazo' => 10,
			),
			'Paraiba - Capital' =>
			array (
				'ini' => '58000001',
				'end' => '58099999',
				'opcoes' =>
				array (
					10 => 65,
					20 => 77,
					30 => 92,
					50 => 104,
					100 => 175,
				),
				'prazo' => 8,
			),
			'Paraiba - Interior' =>
			array (
				'ini' => '58099999',
				'end' => '58999999',
				'opcoes' =>
				array (
					10 => 75,
					20 => 92,
					30 => 107,
					50 => 128,
					100 => 191,
				),
				'prazo' => 12,
			),
			'Piaui - Capital' =>
			array (
				'ini' => '64000001',
				'end' => '64099999',
				'opcoes' =>
				array (
					10 => 74,
					20 => 86,
					30 => 101,
					50 => 127,
					100 => 178,
				),
				'prazo' => 8,
			),
			'Piaui - Interior' =>
			array (
				'ini' => '64099999',
				'end' => '64999999',
				'opcoes' =>
				array (
					10 => 82,
					20 => 91,
					30 => 103,
					50 => 129,
					100 => 174,
				),
				'prazo' => 12,
			),
			'Sergipe - Capital' =>
			array (
				'ini' => '49000001',
				'end' => '49098999',
				'opcoes' =>
				array (
					10 => 78,
					20 => 94,
					30 => 111,
					50 => 137,
					100 => 187,
				),
				'prazo' => 6,
			),
			'Sergipe - Interior' =>
			array (
				'ini' => '49098999',
				'end' => '49999999',
				'opcoes' =>
				array (
					10 => 82,
					20 => 91,
					30 => 117,
					50 => 156,
					100 => 202,
				),
				'prazo' => 9,
			),
			'Maranhão - Capital' =>
			array (
				'ini' => '65000001',
				'end' => '65109999',
				'opcoes' =>
				array (
					10 => 95,
					20 => 124,
					30 => 162,
					50 => 207,
					100 => 248,
				),
				'prazo' => 11,
			),
			'Maranhão - Interior' =>
			array (
				'ini' => '65110000',
				'end' => '65999999',
				'opcoes' =>
				array (
					10 => 107,
					20 => 135,
					30 => 208,
					50 => 262,
					100 => 301,
				),
				'prazo' => 15,
			),
			'Pará - Capital' =>
			array (
				'ini' => '66000001',
				'end' => '66999999',
				'opcoes' =>
				array (
					10 => 75,
					20 => 87,
					30 => 128,
					50 => 186,
					100 => 206,
				),
				'prazo' => 12,
			),
			'Pará - Interior' =>
			array (
				'ini' => '67000000',
				'end' => '68899999',
				'opcoes' =>
				array (
					10 => 98,
					20 => 108,
					30 => 194,
					50 => 245,
					100 => 301,
				),
				'prazo' => 16,
			),
			'Acre - Capital' =>
			array (
				'ini' => '69900001',
				'end' => '69923999',
				'opcoes' =>
				array (
					10 => 84,
					20 => 175,
					30 => 228,
					50 => 384,
					100 => 407,
				),
				'prazo' => 16,
			),
			'Acre - Interior' =>
			array (
				'ini' => '69924000',
				'end' => '69999999',
				'opcoes' =>
				array (
					10 => 84,
					20 => 175,
					30 => 228,
					50 => 384,
					100 => 407,
				),
				'prazo' => 16,
			),
			'Rio Grande do Sul - Capital' =>
			array (
				'ini' => '90000001',
				'end' => '91999999',
				'opcoes' =>
				array (
					10 => 15,
					20 => 0,
					30 => 0,
					50 => 0,
					100 => 0,
				),
				'prazo' => 3,
			),
			'Rio Grande do Sul - Interior' =>
			array (
				'ini' => '92000000',
				'end' => '99999999',
				'opcoes' =>
				array (
					10 => 25,
					20 => 50,
					30 => 70,
					50 => 0,
					100 => 0,
				),
				'prazo' => 7,
			),
		);
	}

	public function __construct($params,$opcao) {
		$this->_params = $params;
	}

	private function _isRegiaoSul($cep) {
		return $cep >= 80000000 && $cep <= 99999999;
	}

	private function _isRegiaoSudeste($cep) {
		return $cep >= '01000000' && $cep <= 39999999;
	}



	private function _isFreteGratis($produtos,$valor_produtos,$cep) {
		if ( $valor_produtos < 800 && $valor_produtos >= 300 ) {
			$states = array('RS','SC','PR','SP');
		} else if ( $valor_produtos >= 800 ) {
			$states = array('DF', 'ES', 'GO', 'PR', 'RJ', 'RS', 'SC', 'SP', 'MG');
		} else {
			return false;
		}
		$table = new Application_Model_DbTable_Estados();
		$select = $table->select()->where('sigla IN(?)',$states);
		$states = $table->fetchAll($select);
		foreach ($states as $state) {
			if ( $cep >= $state['cep_inicio'] && $cep <= $state['cep_fim'] ) {
				return true;
			} else if ( !empty($state['cep_inicio2']) && !empty($state['cep_fim2']) && $cep >= $state['cep_inicio2'] && $cep <= $state['cep_fim2'] ) {
				return true;
			}
		}
		return false;
	}

	private function _getData($cep_destino,$peso) {
		$faixas = $this->_getFaixas();
		$result = array('prazo' => 0,'valor' => 0, 'erro' => 1);
		foreach ($faixas as $faixa) {
			if ($faixa['ini'] <= $cep_destino && $faixa['end'] >= $cep_destino) {
				foreach ($faixa['opcoes'] as $peso_max => $preco) {
					if ($peso_max >= $peso) {
						$result['prazo'] = $faixa['prazo'];
						$result['valor'] = intval($preco*100);
						$result['erro'] = 0;
						break;
					}
				}
				if ($result['erro'] == 0) {
					break;
				}
			}
		}
		if ($this->_isFreteGratis($this->_params['produtos'],$this->_params['valor_produtos']/100,$cep_destino)) {
			$result['valor'] = 0;
		}
		return $result;
	}
	public function consulta() {
		$peso = 0;
		foreach ($this->_params['produtos'] as $produto) {
			$peso += $produto['peso'] * $produto['quantidade'];
		}
		$peso_max = 100;
		$peso = $peso/1000;
		$result = array('valor' => 0);
		do {
			if ($peso >$peso_max) {
				$peso -= $peso_max;
				$aux_peso = $peso_max;
			} else {
				$aux_peso = $peso;
				$peso = 0;
			}
			$aux = $this->_getData($this->_params['cep_destino'],$aux_peso);
			$result['valor'] += $aux['valor'];
			$result['prazo'] = $aux['prazo'];
			$result['erro'] = $aux['erro'];
		} while($peso > 0);
		return $result;
	}
}
