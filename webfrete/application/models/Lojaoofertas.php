<?php

class Application_Model_Lojaoofertas implements Application_Model_Frete
{
	private $_params = null;

	private function _getFaixas() {
        return array (
            'São Paulo - Capital ' =>
            array (
                'ini' => '01000000',
                'end' => '05999999',
                'opcoes' =>
                array (
                    10 => 45.4,
                    20 => 45.4,
                    30 => 48.4,
                    50 => 54.4,
                    70 => 60.4,
                    100 => 108.4,
                ),
                'prazo' => 7,
            ),
            'São Paulo - Interior' =>
            array (
                'ini' => '06000000',
                'end' => '19999999',
                'opcoes' =>
                array (
                    10 => 45.4,
                    20 => 56.8,
                    30 => 62.6,
                    50 => 74.3,
                    70 => 86,
                    100 => 179.6,
                ),
                'prazo' => 10,
            ),
            'Rio de Janeiro - Capital ' =>
            array (
                'ini' => '20000000',
                'end' => '23799999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 52.6,
                    30 => 57.4,
                    50 => 67,
                    70 => 76.6,
                    100 => 156.4,
                ),
                'prazo' => 7,
            ),
            'Rio de Janeiro - Interior' =>
            array (
                'ini' => '23800000',
                'end' => '28999999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 61.4,
                    30 => 68.5,
                    50 => 82.5,
                    70 => 96.5,
                    100 => 208.9,
                ),
                'prazo' => 10,
            ),
            'Espírito Santo - Capital' =>
            array (
                'ini' => '29000000',
                'end' => '29099999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 50,
                    30 => 54.1,
                    50 => 62.4,
                    70 => 70.7,
                    100 => 137.1,
                ),
                'prazo' => 15,
            ),
            'Espírito Santo - Interior' =>
            array (
                'ini' => '29100000',
                'end' => '29999999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 56.4,
                    30 => 62.1,
                    50 => 73.6,
                    70 => 85.1,
                    100 => 177.1,
                ),
                'prazo' => 15,
            ),
            'Minas Gerais - Capital' =>
            array (
                'ini' => '30000001',
                'end' => '31999999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 48.6,
                    30 => 52.4,
                    50 => 60,
                    70 => 67.6,
                    100 => 128.4,
                ),
                'prazo' => 7,
            ),

            'Minas Gerais - Interior ' =>
            array (
                'ini' => '32000000',
                'end' => '39999999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 56.4,
                    30 => 62.1,
                    50 => 73.6,
                    70 => 85.1,
                    100 => 177.1,
                ),
                'prazo' => 10,
            ),
            'Bahia - Capital' =>
            array (
                'ini' => '40000000',
                'end' => '42499999',
                'opcoes' =>
                array (
                    30 => 55.1,
                    50 => 70.4,
                    100 => 234.2,
                ),
                'prazo' => 15,
            ),
            'Bahia - Interior' =>
            array (
                'ini' => '42500000',
                'end' => '48999999',
                'opcoes' =>
                array (
                    30 => 64.2,
                    50 => 81.1,
                    100 => 265.1,
                ),
                'prazo' => 15,
            ),
            'Sergipe - Capital' =>
            array (
                'ini' => '49000000',
                'end' => '49098999',
                'opcoes' =>
                array (
                    30 => 59.3,
                    50 => 77.3,
                    100 => 269,
                ),
                'prazo' => 15,
            ),
            'Sergipe - Interior' =>
            array (
                'ini' => '49099000',
                'end' => '49999999',
                'opcoes' =>
                array (
                    30 => 69.2,
                    50 => 89.5,
                    100 => 307,
                ),
                'prazo' => 15,
            ),
            'Pernambuco - Capital' =>
            array (
                'ini' => '50000000',
                'end' => '52999999',
                'opcoes' =>
                array (
                    30 => 55.8,
                    50 => 71.5,
                    100 => 240,
                ),
                'prazo' => 15,
            ),
            'Pernambuco - Interior' =>
            array (
                'ini' => '53000000',
                'end' => '56999999',
                'opcoes' =>
                array (
                    30 => 65.7,
                    50 => 83.7,
                    100 => 278,
                ),
                'prazo' => 15,
            ),
            'Alagoas - Capital' =>
            array (
                'ini' => '57000000',
                'end' => '57099999',
                'opcoes' =>
                array (
                    30 => 57.9,
                    50 => 74.9,
                    100 => 257,
                ),
                'prazo' => 15,
            ),
            'Alagoas - Interior' =>
            array (
                'ini' => '57100000',
                'end' => '57999999',
                'opcoes' =>
                array (
                    30 => 67.8,
                    50 => 87.1,
                    100 => 295,
                ),
                'prazo' => 15,
            ),
            'Paraiba - Capital' =>
            array (
                'ini' => '58000000',
                'end' => '58099999',
                'opcoes' =>
                array (
                    30 => 78.9,
                    50 => 94.7,
                    100 => 275,
                ),
                'prazo' => 15,
            ),
            'Paraiba - Interior' =>
            array (
                'ini' => '58100000',
                'end' => '58999999',
                'opcoes' =>
                array (
                    30 => 91.9,
                    50 => 112,
                    100 => 339.2,
                ),
                'prazo' => 15,
            ),
            'Rio Grande do Norte - Capital' =>
            array (
                'ini' => '59000000',
                'end' => '59139999',
                'opcoes' =>
                array (
                    30 => 80.3,
                    50 => 97,
                    100 => 286.7,
                ),
                'prazo' => 15,
            ),
            'Rio Grande do Norte - Interior' =>
            array (
                'ini' => '59140000',
                'end' => '59999999',
                'opcoes' =>
                array (
                    30 => 92.6,
                    50 => 113.2,
                    100 => 344.9,
                ),
                'prazo' => 15,
            ),
            'Ceará - Capital' =>
            array (
                'ini' => '60000000',
                'end' => '61599999',
                'opcoes' =>
                array (
                    30 => 83.3,
                    50 => 102,
                    100 => 312.1,
                ),
                'prazo' => 15,
            ),
            'Ceará - Interior' =>
            array (
                'ini' => '61600000',
                'end' => '63999999',
                'opcoes' =>
                array (
                    30 => 92.9,
                    50 => 113.7,
                    100 => 347.3,
                ),
                'prazo' => 15,
            ),
            'Piaui - Capital' =>
            array (
                'ini' => '64000000',
                'end' => '64099999',
                'opcoes' =>
                array (
                    30 => 85.5,
                    50 => 105.6,
                    100 => 330,
                ),
                'prazo' => 15,
            ),
            'Piaui - Interior' =>
            array (
                'ini' => '64100000',
                'end' => '64999999',
                'opcoes' =>
                array (
                    30 => 93.7,
                    50 => 115,
                    100 => 353.8,
                ),
                'prazo' => 15,
            ),
            'Maranhão - Capital' =>
            array (
                'ini' => '65000001',
                'end' => '65109999',
                'opcoes' =>
                array (
                    30 => 89.6,
                    50 => 112.5,
                    100 => 364.6,
                ),
                'prazo' => 15,
            ),
            'Maranhão - Interior' =>
            array (
                'ini' => '65110000',
                'end' => '65999999',
                'opcoes' =>
                array (
                    30 => 98.5,
                    50 => 123,
                    100 => 394,
                ),
                'prazo' => 15,
            ),
            'Acre - Capital' =>
            array (
                'ini' => '69900000',
                'end' => '69990999',
                'opcoes' =>
                array (
                    10 => 65.4,
                    20 => 71.4,
                    30 => 80.9,
                    50 => 99.9,
                    70 => 119.9,
                    100 => 270.9,
                ),
                'prazo' => 15,
            ),
            'Acre - Interior' =>
            array (
                'ini' => '69991000',
                'end' => '69999999',
                'opcoes' =>
                array (
                    10 => 65.4,
                    20 => 74.4,
                    30 => 84.6,
                    50 => 105.1,
                    70 => 125.6,
                    100 => 289.6,
                ),
                'prazo' => 15,
            ),
            'Distrito Federal - Capital / Metropolis' =>
            array (
                'ini' => '70000000',
                'end' => '72799999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 49.8,
                    30 => 53.9,
                    50 => 62.1,
                    70 => 70.3,
                    100 => 135.9,
                ),
                'prazo' => 15,
            ),
            'Distrito Federal - Interior' =>
            array (
                'ini' => '73000000',
                'end' => '73699999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 55.4,
                    30 => 60.9,
                    50 => 71.9,
                    70 => 82.9,
                    100 => 170.9,
                ),
                'prazo' => 15,
            ),
            'Goias - Interior' =>
            array (
                'ini' => '72800000',
                'end' => '72999999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 49.4,
                    30 => 53.4,
                    50 => 61.4,
                    70 => 69.4,
                    100 => 133.4,
                ),
                'prazo' => 15,
            ),
            'Goias - Capital / Aparecida' =>
            array (
                'ini' => '73700000',
                'end' => '76799999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 56.4,
                    30 => 62.1,
                    50 => 73.6,
                    70 => 85.1,
                    100 => 177.1,
                ),
                'prazo' => 15,
            ),
            'Rondonia - Capital' =>
            array (
                'ini' => '76800000',
                'end' => '76834999',
                'opcoes' =>
                array (
                    10 => 65.4,
                    20 => 65.4,
                    30 => 73.4,
                    50 => 89.4,
                    70 => 105.4,
                    100 => 233.4,
                ),
                'prazo' => 15,
            ),
            'Rondonia - Interior' =>
            array (
                'ini' => '76835000',
                'end' => '78999999',
                'opcoes' =>
                array (
                    10 => 65.4,
                    20 => 70.4,
                    30 => 79.6,
                    50 => 98.1,
                    70 => 116.6,
                    100 => 264.6,
                ),
                'prazo' => 15,
            ),
            'Tocantins - Capital' =>
            array (
                'ini' => '77000000',
                'end' => '77249999',
                'opcoes' =>
                array (
                    10 => 65.4,
                    20 => 69.4,
                    30 => 78.4,
                    50 => 96.4,
                    70 => 114.4,
                    100 => 258.4,
                ),
                'prazo' => 15,
            ),
            'Tocantins - Interior' =>
            array (
                'ini' => '77250000',
                'end' => '77999999',
                'opcoes' =>
                array (
                    10 => 65.4,
                    20 => 72.4,
                    30 => 82.1,
                    50 => 101.6,
                    70 => 121.1,
                    100 => 277.1,
                ),
                'prazo' => 15,
            ),
            'Mato Grosso - Capital' =>
            array (
                'ini' => '78000000',
                'end' => '78099999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 49.4,
                    30 => 53.4,
                    50 => 61.4,
                    70 => 69.4,
                    100 => 133.4,
                ),
                'prazo' => 15,
            ),
            'Mato Grosso - Interior' =>
            array (
                'ini' => '78100000',
                'end' => '78899999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 59.4,
                    30 => 65.9,
                    50 => 78.9,
                    70 => 91.9,
                    100 => 195.9,
                ),
                'prazo' => 15,
            ),
            'Mato Grosso Sul - Capital ' =>
            array (
                'ini' => '79000000',
                'end' => '79124999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 48.4,
                    30 => 52.1,
                    50 => 59.6,
                    70 => 67.1,
                    100 => 127.1,
                ),
                'prazo' => 15,
            ),
            'Mato Grosso Sul - Interior' =>
            array (
                'ini' => '79125000',
                'end' => '79999999',
                'opcoes' =>
                array (
                    10 => 48.4,
                    20 => 57.4,
                    30 => 63.4,
                    50 => 75.4,
                    70 => 87.4,
                    100 => 183.4,
                ),
                'prazo' => 15,
            ),
            'Paraná - Capital ' =>
            array (
                'ini' => '80000000',
                'end' => '82999999',
                'opcoes' =>
                array (
                    10 => 43.4,
                    20 => 42.6,
                    30 => 44.9,
                    50 => 49.5,
                    70 => 54.1,
                    100 => 90.9,
                ),
                'prazo' => 7,
            ),
            'Paraná - Interior' =>
            array (
                'ini' => '83000000',
                'end' => '87999999',
                'opcoes' =>
                array (
                    10 => 43.4,
                    20 => 49.4,
                    30 => 53.4,
                    50 => 61.4,
                    70 => 69.4,
                    100 => 133.4,
                ),
                'prazo' => 10,
            ),
            'Santa Catarina - Capital' =>
            array (
                'ini' => '88000000',
                'end' => '88099999',
                'opcoes' =>
                array (
                    10 => 44.4,
                    20 => 41.4,
                    30 => 43.4,
                    50 => 47.4,
                    70 => 51.4,
                    100 => 83.4,
                ),
                'prazo' => 7,
            ),
            'Santa Catarina - Interior' =>
            array (
                'ini' => '88100000',
                'end' => '89999999',
                'opcoes' =>
                array (
                    10 => 44.4,
                    20 => 47.4,
                    30 => 50.9,
                    50 => 57.9,
                    70 => 64.9,
                    100 => 120.9,
                ),
                'prazo' => 7,
            ),
            'Rio Grande do Sul - Capital' =>
            array (
                'ini' => '90000000',
                'end' => '91999999',
                'opcoes' =>
                array (
                    10 => 35.6,
                    20 => 36.2,
                    30 => 37.6,
                    50 => 40.4,
                    70 => 43.2,
                    100 => 65.6,
                ),
                'prazo' => 5,
            ),
            'Rio Grande do Sul - Interior' =>
            array (
                'ini' => '92000000',
                'end' => '99999999',
                'opcoes' =>
                array (
                    10 => 43.4,
                    20 => 48.4,
                    30 => 52.1,
                    50 => 59.6,
                    70 => 67.1,
                    100 => 127.1,
                ),
                'prazo' => 5,
            ),
        );
	}

	public function __construct($params,$opcao) {
		$this->_params = $params;
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
