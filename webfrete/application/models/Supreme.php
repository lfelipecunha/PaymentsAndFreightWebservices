<?php

class Application_Model_Supreme implements Application_Model_Frete
{
	private $_params = null;

	private function _getFaixas() {
		return array (
		  'Rondonia - Capital' =>
		  array (
		    'ini' => '76800001',
		    'end' => '76834999',
		    'opcoes' =>
		    array (
		      10 => 39.27,
		      20 => 69.02,
		      30 => 80.67,
		      50 => 111.62,
		      100 => 158.45,
		    ),
		    'prazo' => 15,
		  ),
		  'Rondonia - Interior' =>
		  array (
		    'ini' => '76835000',
		    'end' => '76999999',
		    'opcoes' =>
		    array (
		      10 => 52.57,
		      20 => 84.33,
		      30 => 132.46,
		      50 => 147.85,
		      100 => 215.64,
		    ),
		    'prazo' => 15,
		  ),
		  'Bahia - Capital' =>
		  array (
		    'ini' => '40000001',
		    'end' => '42499999',
		    'opcoes' =>
		    array (
		      10 => 37.98,
		      20 => 51.33,
		      30 => 60.46,
		      50 => 75.15,
		      100 => 115.48,
		    ),
		    'prazo' => 15,
		  ),
		  'Bahia - Interior' =>
		  array (
		    'ini' => '42500000',
		    'end' => '48999999',
		    'opcoes' =>
		    array (
		      10 => 45.91,
		      20 => 62.66,
		      30 => 75.8,
		      50 => 98.77,
		      100 => 117.58,
		    ),
		    'prazo' => 15,
		  ),
		  'Tocantins - Capital' =>
		  array (
		    'ini' => '77000001',
		    'end' => '77249999',
		    'opcoes' =>
		    array (
		      10 => 34.24,
		      20 => 65.01,
		      30 => 75.44,
		      50 => 114.56,
		      100 => 185.55,
		    ),
		    'prazo' => 15,
		  ),
		  'Tocantins - Interior 1' =>
		  array (
		    'ini' => '77250000',
		    'end' => '77999999',
		    'opcoes' =>
		    array (
		      10 => 59.33,
		      20 => 77.1,
		      30 => 96.53,
		      50 => 174.52,
		      100 => 224.65,
		    ),
		    'prazo' => 15,
		  ),
		  'Goias - Capital / Aparecida' =>
		  array (
		    'ini' => '74000001',
		    'end' => '74899999',
		    'opcoes' =>
		    array (
		      10 => 36.45,
		      20 => 45.07,
		      30 => 66.62,
		      50 => 80.88,
		      100 => 112.74,
		    ),
		    'prazo' => 15,
		  ),
		  'Goias - Interior' =>
		  array (
		    'ini' => '73700000',
		    'end' => '74898999',
		    'opcoes' =>
		    array (
		      10 => 48.54,
		      20 => 56.31,
		      30 => 83.91,
		      50 => 114.75,
		      100 => 184.52,
		    ),
		    'prazo' => 15,
		  ),
		  'Distrito Federal - Capital / Metropolis' =>
		  array (
		    'ini' => '70000001',
		    'end' => '72799999',
		    'opcoes' =>
		    array (
		      10 => 36.69,
		      20 => 45.46,
		      30 => 67.4,
		      50 => 82.34,
		      100 => 112.25,
		    ),
		    'prazo' => 15,
		  ),
		  'Distrito Federal - Interior' =>
		  array (
		    'ini' => '73000000',
		    'end' => '73699999',
		    'opcoes' =>
		    array (
		      10 => 45.8,
		      20 => 53.74,
		      30 => 70.71,
		      50 => 90.24,
		      100 => 136.85,
		    ),
		    'prazo' => 15,
		  ),
		  'Mato Grosso - Capital / Varzea Grande' =>
		  array (
		    'ini' => '78000001',
		    'end' => '78099999',
		    'opcoes' =>
		    array (
		      10 => 36.45,
		      20 => 45.07,
		      30 => 66.62,
		      50 => 78.56,
		      100 => 158.45,
		    ),
		    'prazo' => 15,
		  ),
		  'Mato Grosso - Sinop/Rondonópolis' =>
		  array (
		    'ini' => '78550001',
		    'end' => '78559999',
		    'opcoes' =>
		    array (
		      10 => 47.06,
		      20 => 54.82,
		      30 => 78.71,
		      50 => 93.85,
		      100 => 162.45,
		    ),
		    'prazo' => 15,
		  ),
		  'Mato Grosso - Interior' =>
		  array (
		    'ini' => '78000000',
		    'end' => '78899999',
		    'opcoes' =>
		    array (
		      10 => 63.99,
		      20 => 77.1,
		      30 => 109.89,
		      50 => 178.52,
		      100 => 195.85,
		    ),
		    'prazo' => 15,
		  ),
		  'Mato Grosso Sul - Capital ' =>
		  array (
		    'ini' => '79000001',
		    'end' => '79124999',
		    'opcoes' =>
		    array (
		      10 => 35.06,
		      20 => 42.74,
		      30 => 61.96,
		      50 => 88.45,
		      100 => 128.74,
		    ),
		    'prazo' => 15,
		  ),
		  'Mato Grosso Sul - Dourados' =>
		  array (
		    'ini' => '79800001',
		    'end' => '79849999',
		    'opcoes' =>
		    array (
		      10 => 35.06,
		      20 => 42.74,
		      30 => 61.96,
		      50 => 88.45,
		      100 => 128.74,
		    ),
		    'prazo' => 15,
		  ),
		  'Mato Grosso Sul - Interior' =>
		  array (
		    'ini' => '79850000',
		    'end' => '79999999',
		    'opcoes' =>
		    array (
		      10 => 56.79,
		      20 => 68.09,
		      30 => 96.32,
		      50 => 134.86,
		      100 => 168.44,
		    ),
		    'prazo' => 15,
		  ),
		  'Minas Gerais - Capital' =>
		  array (
		    'ini' => '30000001',
		    'end' => '31999999',
		    'opcoes' =>
		    array (
		      10 => 35.29,
		      20 => 43.13,
		      30 => 62.73,
		      50 => 82.42,
		      100 => 112.61,
		    ),
		    'prazo' => 7,
		  ),
		  'Minas Gerais - Interior ' =>
		  array (
		    'ini' => '32000000',
		    'end' => '39999999',
		    'opcoes' =>
		    array (
		      10 => 50.35,
		      20 => 57.34,
		      30 => 74.82,
		      50 => 89.65,
		      100 => 116.82,
		    ),
		    'prazo' => 10,
		  ),
		  'Espírito Santo - Capital' =>
		  array (
		    'ini' => '29000001',
		    'end' => '29099999',
		    'opcoes' =>
		    array (
		      10 => 37.39,
		      20 => 46.63,
		      30 => 69.73,
		      50 => 79.52,
		      100 => 102.85,
		    ),
		    'prazo' => 15,
		  ),
		  'Espírito Santo - Interior' =>
		  array (
		    'ini' => '29100000',
		    'end' => '29999999',
		    'opcoes' =>
		    array (
		      10 => 59.13,
		      20 => 71.97,
		      30 => 104.09,
		      50 => 127.07,
		      100 => 156.89,
		    ),
		    'prazo' => 15,
		  ),
		  'São Paulo - Capital ' =>
		  array (
		    'ini' => '08000000',
		    'end' => '08499999',
		    'opcoes' =>
		    array (
		      10 => 36.39,
		      20 => 40.02,
		      30 => 56.52,
		      50 => 64.85,
		      100 => 77.88,
		    ),
		    'prazo' => 7,
		  ),
		  'São Paulo - Interior' =>
		  array (
		    'ini' => '08500000',
		    'end' => '19999999',
		    'opcoes' =>
		    array (
		      10 => 60.33,
		      20 => 69.08,
		      30 => 99.79,
		      50 => 111.24,
		      100 => 141.89,
		    ),
		    'prazo' => 10,
		  ),
		  'Rio de Janeiro - Capital ' =>
		  array (
		    'ini' => '20000001',
		    'end' => '23799999',
		    'opcoes' =>
		    array (
		      10 => 38.26,
		      20 => 43.13,
		      30 => 62.73,
		      50 => 75.6,
		      100 => 82.45,
		    ),
		    'prazo' => 7,
		  ),
		  'Rio de Janeiro - Interior' =>
		  array (
		    'ini' => '23800000',
		    'end' => '28999999',
		    'opcoes' =>
		    array (
		      10 => 47.26,
		      20 => 52.25,
		      30 => 71.73,
		      50 => 81.67,
		      100 => 100.54,
		    ),
		    'prazo' => 10,
		  ),
		  'Paraná - Capital ' =>
		  array (
		    'ini' => '80000001',
		    'end' => '82999999',
		    'opcoes' =>
		    array (
		      10 => 31.56,
		      20 => 36.92,
		      30 => 50.3,
		      50 => 59.84,
		      100 => 75.85,
		    ),
		    'prazo' => 7,
		  ),
		  'Paraná - Interior' =>
		  array (
		    'ini' => '83000000',
		    'end' => '87999999',
		    'opcoes' =>
		    array (
		      10 => 49.95,
		      20 => 58.46,
		      30 => 78.73,
		      50 => 80.97,
		      100 => 98.04,
		    ),
		    'prazo' => 10,
		  ),
		  'Santa Catarina - Capital' =>
		  array (
		    'ini' => '88000001',
		    'end' => '88099999',
		    'opcoes' =>
		    array (
		      10 => 31.33,
		      20 => 36.52,
		      30 => 49.52,
		      50 => 55.69,
		      100 => 68.85,
		    ),
		    'prazo' => 7,
		  ),
		  'Santa Catarina - Interior' =>
		  array (
		    'ini' => '88100000',
		    'end' => '89999999',
		    'opcoes' =>
		    array (
		      10 => 37.57,
		      20 => 43.95,
		      30 => 59.92,
		      50 => 74.85,
		      100 => 90.85,
		    ),
		    'prazo' => 7,
		  ),
		  'Rio Grande do Sul - Interior' =>
		  array (
		    'ini' => '92000000',
		    'end' => '99999999',
		    'opcoes' =>
		    array (
		      10 => 24.62,
		      20 => 28.54,
		      30 => 38.77,
		      50 => 45.89,
		      100 => 62.35,
		    ),
		    'prazo' => 5,
		  ),
		  'Rio Grande do Sul - Capital' =>
		  array (
		    'ini' => '90000001',
		    'end' => '91999999',
		    'opcoes' =>
		    array (
		      10 => 20,
		      20 => 20,
		      30 => 20,
		      50 => 20,
		      100 => 20,
		    ),
		    'prazo' => 5,
		  ),
		  'Ceará - Capital' =>
		  array (
		    'ini' => '60000001',
		    'end' => '61599999',
		    'opcoes' =>
		    array (
		      10 => 76.3,
		      20 => 86.47,
		      30 => 101.27,
		      50 => 157.89,
		      100 => 254.98,
		    ),
		    'prazo' => 15,
		  ),
		  'Ceará - Interior' =>
		  array (
		    'ini' => '61600000',
		    'end' => '63999999',
		    'opcoes' =>
		    array (
		      10 => 89.53,
		      20 => 102.77,
		      30 => 168.65,
		      50 => 214.77,
		      100 => 298.54,
		    ),
		    'prazo' => 15,
		  ),
		  'Pernambuco - Capital' =>
		  array (
		    'ini' => '50000001',
		    'end' => '52999999',
		    'opcoes' =>
		    array (
		      10 => 72.56,
		      20 => 84.43,
		      30 => 115.64,
		      50 => 159.87,
		      100 => 227.47,
		    ),
		    'prazo' => 15,
		  ),
		  'Pernambuco - Interior' =>
		  array (
		    'ini' => '53000000',
		    'end' => '56999999',
		    'opcoes' =>
		    array (
		      10 => 79.45,
		      20 => 91.45,
		      30 => 112.64,
		      50 => 174.84,
		      100 => 238.65,
		    ),
		    'prazo' => 15,
		  ),
		  'Rio Grande do Norte - Capital' =>
		  array (
		    'ini' => '59000001',
		    'end' => '59139999',
		    'opcoes' =>
		    array (
		      10 => 86.27,
		      20 => 92.76,
		      30 => 114.77,
		      50 => 182.66,
		      100 => 273.85,
		    ),
		    'prazo' => 15,
		  ),
		  'Rio Grande do Norte - Interior' =>
		  array (
		    'ini' => '59140999',
		    'end' => '59999999',
		    'opcoes' =>
		    array (
		      10 => 95.15,
		      20 => 102.74,
		      30 => 148.45,
		      50 => 197.67,
		      100 => 284.85,
		    ),
		    'prazo' => 15,
		  ),
		  'Alagoas - Capital' =>
		  array (
		    'ini' => '57000001',
		    'end' => '57099999',
		    'opcoes' =>
		    array (
		      10 => 89.4,
		      20 => 97.45,
		      30 => 113.85,
		      50 => 184.21,
		      100 => 224.54,
		    ),
		    'prazo' => 15,
		  ),
		  'Alagoas - Interior' =>
		  array (
		    'ini' => '57100000',
		    'end' => '57999999',
		    'opcoes' =>
		    array (
		      10 => 91.77,
		      20 => 101.02,
		      30 => 126.84,
		      50 => 172.66,
		      100 => 201.02,
		    ),
		    'prazo' => 15,
		  ),
		  'Paraiba - Capital' =>
		  array (
		    'ini' => '58000001',
		    'end' => '58099999',
		    'opcoes' =>
		    array (
		      10 => 65.2,
		      20 => 77.65,
		      30 => 92.57,
		      50 => 104.86,
		      100 => 175.87,
		    ),
		    'prazo' => 15,
		  ),
		  'Paraiba - Interior' =>
		  array (
		    'ini' => '58100000',
		    'end' => '58999999',
		    'opcoes' =>
		    array (
		      10 => 75.88,
		      20 => 92.85,
		      30 => 107.95,
		      50 => 128.93,
		      100 => 191.47,
		    ),
		    'prazo' => 15,
		  ),
		  'Piaui - Capital' =>
		  array (
		    'ini' => '64000001',
		    'end' => '64099999',
		    'opcoes' =>
		    array (
		      10 => 74.89,
		      20 => 86.77,
		      30 => 101.08,
		      50 => 127.46,
		      100 => 178.69,
		    ),
		    'prazo' => 15,
		  ),
		  'Piaui - Interior' =>
		  array (
		    'ini' => '64100000',
		    'end' => '64999999',
		    'opcoes' =>
		    array (
		      10 => 82.45,
		      20 => 91.72,
		      30 => 103.44,
		      50 => 129.02,
		      100 => 174.67,
		    ),
		    'prazo' => 15,
		  ),
		  'Sergipe - Capital' =>
		  array (
		    'ini' => '49000001',
		    'end' => '49098999',
		    'opcoes' =>
		    array (
		      10 => 78.47,
		      20 => 94.85,
		      30 => 111.52,
		      50 => 137.66,
		      100 => 187.65,
		    ),
		    'prazo' => 15,
		  ),
		  'Sergipe - Interior' =>
		  array (
		    'ini' => '49099000',
		    'end' => '49999999',
		    'opcoes' =>
		    array (
		      10 => 82.44,
		      20 => 91.74,
		      30 => 117.84,
		      50 => 156.94,
		      100 => 202.45,
		    ),
		    'prazo' => 15,
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
        if ($valor_produtos < 80000) {
            return false;
        }
/*		if (($this->_isRegiaoSul($cep_destino) || $this->_isRegiaoSudeste($cep_destino)) && $valor_produtos > 50000) {
			return true;
		}*/
        $states = array('DF', 'ES', 'GO', 'PR', 'RJ', 'RS', 'SC', 'SP', 'MG', 'BA');
        $table = new Application_Model_DbTable_Estados();
        $select = $table->select()->where('sigla IN(?)',$states);
        $states = $table->fetchAll($select);
		foreach ($produtos as $produto) {
			//if ($produto['departamento'] == 22 || $produto['departamento'] == 25 || $produto['categoria'] == 53 || $produto['categoria'] == 29 || $produto['categoria'] == 40) {
                foreach ($states as $state) {
                    if ($cep >= $state['cep_inicio'] && $cep <= $state['cep_fim']) {
                        return true;
                    } else if (!empty($state['cep_inicio2']) && !empty($state['cep_fim2']) && $cep >= $state['cep_inicio2'] && $cep <= $state['cep_fim2']) {
                        return true;
                    }
                }
			//}
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
		if ($this->_isFreteGratis($this->_params['produtos'],$this->_params['valor_produtos'],$cep_destino)) {
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
