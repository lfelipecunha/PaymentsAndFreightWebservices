<?php

class Application_Model_VinhosESabores implements Application_Model_Frete
{
	private $_params = null;

	private function _getFaixas() {
	return
		array (
			'S�o Paulo - Capital' =>
			array (
				'ini' => '01000000',
				'end' => '05999999',
				'opcoes' =>
				array (
					30 => 52,
					50 => 54,
					100 => 65,
					150 => 70,
					200 => 80,
					250 => 85,
					300 => 90,
					350 => 99,
					400 => 110,
					450 => 140,
					520 => 165,
				),
				'prazo' => 3,
			),
			'S�o Paulo - Interior' =>
			array (
				'ini' => '06000000',
				'end' => '19999999',
				'opcoes' =>
				array (
					30 => 54,
					50 => 54,
					100 => 54,
					150 => 54,
					200 => 66,
					250 => 88,
					300 => 99,
					350 => 110,
					410 => 209,
					470 => 242,
				),
				'prazo' => 6,
			),
			'Rio de Janeiro - Capital' =>
			array (
				'ini' => '20000000',
				'end' => '23799999',
				'opcoes' =>
				array (
					30 => 55,
					50 => 60,
					100 => 65,
					150 => 70,
					200 => 86,
					250 => 95,
					300 => 105,
					350 => 120,
					400 => 130,
					450 => 150,
					500 => 200,
					550 => 220,
				),
				'prazo' => 4,
			),
			'Rio de Janeiro - Interior' =>
			array (
				'ini' => '23800000',
				'end' => '28999999',
				'opcoes' =>
				array (
					30 => 49.5,
					50 => 65,
					100 => 76,
					150 => 98,
					200 => 110,
					250 => 120,
					300 => 132,
					350 => 142,
					400 => 153,
					450 => 164,
					500 => 175,
					550 => 198,
				),
				'prazo' => 6,
			),
			'Esp�rito Santo - Capital' =>
			array (
				'ini' => '29000000',
				'end' => '29099999',
				'opcoes' =>
				array (
					30 => 40,
					50 => 50,
					100 => 70,
					150 => 90,
					200 => 95,
					250 => 105,
					300 => 135,
					350 => 150,
					400 => 160,
					450 => 180,
				),
				'prazo' => 7,
			),
			'Esp�rito Santo - Interior' =>
			array (
				'ini' => '29100000',
				'end' => '29999999',
				'opcoes' =>
				array (
					30 => 45,
					50 => 60,
					100 => 75,
					150 => 95,
					200 => 102,
					250 => 110,
					300 => 140,
					350 => 159,
					400 => 170,
					450 => 200,
				),
				'prazo' => 7,
			),
			'Minas Gerais - Capital' =>
			array (
				'ini' => '30000001',
				'end' => '31999999',
				'opcoes' =>
				array (
					30 => 40,
					50 => 45,
					100 => 54,
					150 => 60,
					200 => 77,
					250 => 82,
					300 => 999,
					350 => 150,
					400 => 165,
					450 => 180,
					500 => 220,
					550 => 270,
					600 => 290,
				),
				'prazo' => 7,
			),
			'Minas Gerais - Interior' =>
			array (
				'ini' => '32000000',
				'end' => '39999999',
				'opcoes' =>
				array (
					30 => 45,
					50 => 48,
					100 => 70,
					150 => 80,
					200 => 90,
					250 => 100,
					300 => 110,
					350 => 140,
					400 => 175,
					450 => 195,
					500 => 240,
					550 => 310,
					600 => 330,
				),
				'prazo' => 8,
			),
			'Bahia - Capital' =>
			array (
				'ini' => '40000000',
				'end' => '42499999',
				'opcoes' =>
				array (
					30 => 44,
					50 => 55,
					100 => 100,
					150 => 140,
					200 => 160,
					250 => 180,
					300 => 200,
					350 => 220,
					400 => 250,
				),
				'prazo' => 15,
			),
			'Bahia - Interior' =>
			array (
				'ini' => '42500000',
				'end' => '48999999',
				'opcoes' =>
				array (
					30 => 50,
					50 => 65,
					100 => 120,
					150 => 150,
					200 => 170,
					250 => 200,
					300 => 220,
					350 => 250,
					400 => 300,
				),
				'prazo' => 15,
			),
			'Sergipe - Capital' =>
			array (
				'ini' => '49000000',
				'end' => '49098999',
				'opcoes' =>
				array (
					30 => 49,
					50 => 65,
					100 => 105,
					150 => 140,
					200 => 175,
					250 => 190,
					300 => 210,
					350 => 230,
					400 => 260,
				),
				'prazo' => 15,
			),
			'Sergipe - Interior' =>
			array (
				'ini' => '49099000',
				'end' => '49999999',
				'opcoes' =>
				array (
					30 => 55,
					50 => 75,
					100 => 120,
					150 => 150,
					200 => 180,
					250 => 210,
					300 => 230,
					350 => 260,
					400 => 290,
				),
				'prazo' => 15,
			),
			'Pernambuco - Capital' =>
			array (
				'ini' => '50000000',
				'end' => '52999999',
				'opcoes' =>
				array (
					30 => 45,
					50 => 60,
					100 => 90,
					150 => 140,
					200 => 170,
					250 => 200,
					300 => 210,
					350 => 230,
					400 => 250,
				),
				'prazo' => 15,
			),
			'Pernambuco - Interior' =>
			array (
				'ini' => '53000000',
				'end' => '56999999',
				'opcoes' =>
				array (
					30 => 54,
					50 => 70,
					100 => 100,
					150 => 160,
					200 => 180,
					250 => 210,
					300 => 230,
					350 => 250,
					400 => 270,
				),
				'prazo' => 15,
			),
			'Alagoas - Capital' =>
			array (
				'ini' => '57000000',
				'end' => '57099999',
				'opcoes' =>
				array (
					30 => 45,
					50 => 60,
					100 => 100,
					150 => 120,
					200 => 180,
					250 => 210,
					300 => 230,
					350 => 245,
					400 => 260,
				),
				'prazo' => 15,
			),
			'Alagoas - Interior' =>
			array (
				'ini' => '57100000',
				'end' => '57999999',
				'opcoes' =>
				array (
					30 => 55,
					50 => 70,
					100 => 110,
					150 => 150,
					200 => 220,
					250 => 230,
					300 => 240,
					350 => 255,
					400 => 265,
				),
				'prazo' => 15,
			),
			'Paraiba - Capital' =>
			array (
				'ini' => '58000000',
				'end' => '58099999',
				'opcoes' =>
				array (
					30 => 65,
					50 => 80,
					100 => 120,
					150 => 140,
					200 => 160,
					250 => 170,
					300 => 180,
					350 => 190,
					400 => 200,
				),
				'prazo' => 15,
			),
			'Paraiba - Interior' =>
			array (
				'ini' => '58100000',
				'end' => '58999999',
				'opcoes' =>
				array (
					30 => 75,
					50 => 90,
					100 => 140,
					150 => 150,
					200 => 180,
					250 => 190,
					300 => 200,
					350 => 210,
					400 => 220,
				),
				'prazo' => 15,
			),
			'Rio Grande do Norte - Capital' =>
			array (
				'ini' => '59000000',
				'end' => '59139999',
				'opcoes' =>
				array (
					30 => 65,
					50 => 80,
					100 => 120,
					150 => 150,
					200 => 170,
					250 => 190,
					300 => 210,
					350 => 230,
					400 => 245,
				),
				'prazo' => 15,
			),
			'Rio Grande do Norte - Interior' =>
			array (
				'ini' => '59140000',
				'end' => '59999999',
				'opcoes' =>
				array (
					30 => 75,
					50 => 90,
					100 => 147,
					150 => 169,
					200 => 199,
					250 => 210,
					300 => 225,
					350 => 240,
					400 => 265,
				),
				'prazo' => 15,
			),
			'Cear� - Capital' =>
			array (
				'ini' => '60000000',
				'end' => '61599999',
				'opcoes' =>
				array (
					30 => 80,
					50 => 110,
					100 => 140,
					150 => 170,
					200 => 210,
					250 => 250,
					300 => 260,
					350 => 280,
					400 => 300,
				),
				'prazo' => 15,
			),
			'Cear� - Interior' =>
			array (
				'ini' => '61600000',
				'end' => '63999999',
				'opcoes' =>
				array (
					30 => 90,
					50 => 125,
					100 => 170,
					150 => 200,
					200 => 250,
					250 => 260,
					300 => 280,
					350 => 310,
					400 => 320,
				),
				'prazo' => 15,
			),
			'Piaui - Capital' =>
			array (
				'ini' => '64000000',
				'end' => '64099999',
				'opcoes' =>
				array (
					30 => 70,
					50 => 90,
					100 => 140,
					150 => 160,
					200 => 180,
					250 => 220,
					300 => 230,
					350 => 245,
					400 => 260,
				),
				'prazo' => 15,
			),
			'Piaui - Interior' =>
			array (
				'ini' => '64100000',
				'end' => '64999999',
				'opcoes' =>
				array (
					30 => 75,
					50 => 95,
					100 => 150,
					150 => 190,
					200 => 210,
					250 => 230,
					300 => 240,
					350 => 255,
					400 => 270,
				),
				'prazo' => 15,
			),
			'Maranh�o - Capital' =>
			array (
				'ini' => '65000001',
				'end' => '65109999',
				'opcoes' =>
				array (
					30 => 75,
					50 => 95,
					100 => 150,
					150 => 170,
					200 => 190,
					250 => 220,
					300 => 230,
					350 => 240,
					400 => 250,
				),
				'prazo' => 15,
			),
			'Maranh�o - Interior' =>
			array (
				'ini' => '65110000',
				'end' => '65999999',
				'opcoes' =>
				array (
					30 => 80,
					50 => 100,
					100 => 165,
					150 => 199,
					200 => 250,
					250 => 255,
					300 => 260,
					350 => 265,
					400 => 270,
				),
				'prazo' => 15,
			),
			'Par� - Capital' =>
			array (
				'ini' => '66000000',
				'end' => '66999999',
				'opcoes' =>
				array (
					30 => 170,
					50 => 190,
					100 => 219,
					150 => 245,
					200 => 325,
					250 => 350,
					300 => 400,
					350 => 430,
					400 => 450,
				),
				'prazo' => 15,
			),
			'Par� - Interior' =>
			array (
				'ini' => '67000000',
				'end' => '68899999',
				'opcoes' =>
				array (
					30 => 180,
					50 => 210,
					100 => 230,
					150 => 270,
					200 => 350,
					250 => 370,
					300 => 450,
					350 => 480,
					400 => 500,
				),
				'prazo' => 15,
			),
			'Amazonas - Capital' =>
			array (
				'ini' => '69000000',
				'end' => '69290999',
				'opcoes' =>
				array (
					30 => 200,
					50 => 220,
					100 => 230,
					150 => 260,
					200 => 350,
					250 => 400,
					300 => 500,
				),
				'prazo' => 15,
			),
			'Amazonas - Interior' =>
			array (
				'ini' => '69400000',
				'end' => '69899999',
				'opcoes' =>
				array (
					30 => 220,
					50 => 230,
					100 => 250,
					150 => 290,
					200 => 376,
					250 => 450,
					300 => 550,
				),
				'prazo' => 15,
			),
			'Acre - Capital' =>
			array (
				'ini' => '69900000',
				'end' => '69990999',
				'opcoes' =>
				array (
					30 => 66,
					50 => 88,
					100 => 142,
					150 => 170,
					200 => 230,
					250 => 250,
					300 => 270,
					350 => 300,
					400 => 350,
				),
				'prazo' => 15,
			),
			'Acre - Interior' =>
			array (
				'ini' => '69991000',
				'end' => '69999999',
				'opcoes' =>
				array (
					30 => 70,
					50 => 95,
					100 => 160,
					150 => 200,
					200 => 250,
					250 => 260,
					300 => 280,
					350 => 320,
					400 => 370,
				),
				'prazo' => 15,
			),
			'Distrito Federal - Capital / Metropolis' =>
			array (
				'ini' => '70000000',
				'end' => '72799999',
				'opcoes' =>
				array (
					30 => 40,
					50 => 50,
					100 => 70,
					150 => 75,
					200 => 80,
					250 => 90,
					300 => 100,
					350 => 110,
					400 => 120,
					450 => 150,
				),
				'prazo' => 15,
			),
			'Goias - Interior' =>
			array (
				'ini' => '72800000',
				'end' => '72999999',
				'opcoes' =>
				array (
					30 => 50,
					50 => 60,
					100 => 90,
					150 => 110,
					200 => 120,
					250 => 130,
					300 => 160,
				),
				'prazo' => 15,
			),
			'Distrito Federal - Interior' =>
			array (
				'ini' => '73000000',
				'end' => '73699999',
				'opcoes' =>
				array (
					30 => 45,
					50 => 50,
					100 => 75,
					150 => 85,
					200 => 90,
					250 => 100,
					300 => 120,
					350 => 130,
					400 => 140,
				),
				'prazo' => 15,
			),
			'Goias - Capital / Aparecida' =>
			array (
				'ini' => '73700000',
				'end' => '76799999',
				'opcoes' =>
				array (
					30 => 40,
					50 => 50,
					100 => 70,
					150 => 103,
					200 => 120,
					250 => 140,
					300 => 150,
					350 => 160,
					400 => 190,
				),
				'prazo' => 15,
			),
			'Rondonia - Capital' =>
			array (
				'ini' => '76800000',
				'end' => '76834999',
				'opcoes' =>
				array (
					30 => 70,
					50 => 80,
					100 => 120,
					150 => 150,
					200 => 180,
					250 => 200,
				),
				'prazo' => 15,
			),
			'Rondonia - Interior' =>
			array (
				'ini' => '76835000',
				'end' => '78999999',
				'opcoes' =>
				array (
					30 => 79,
					50 => 100,
					100 => 150,
					150 => 165,
					200 => 211,
					250 => 230,
				),
				'prazo' => 15,
			),
			'Tocantins - Capital' =>
			array (
				'ini' => '77000000',
				'end' => '77249999',
				'opcoes' =>
				array (
					30 => 60,
					50 => 80,
					100 => 130,
					150 => 150,
					200 => 160,
					250 => 190,
					300 => 210,
					350 => 220,
					400 => 230,
				),
				'prazo' => 15,
			),
			'Tocantins - Interior' =>
			array (
				'ini' => '77250000',
				'end' => '77999999',
				'opcoes' =>
				array (
					30 => 60,
					50 => 80,
					100 => 140,
					150 => 150,
					200 => 180,
					250 => 200,
					300 => 220,
					350 => 230,
					400 => 240,
				),
				'prazo' => 15,
			),
			'Mato Grosso - Capital' =>
			array (
				'ini' => '78000000',
				'end' => '78099999',
				'opcoes' =>
				array (
					30 => 45,
					50 => 55,
					100 => 79,
					150 => 120,
					200 => 150,
					250 => 160,
					300 => 200,
					350 => 230,
					400 => 240,
				),
				'prazo' => 15,
			),
			'Mato Grosso - Interior' =>
			array (
				'ini' => '78100000',
				'end' => '78899999',
				'opcoes' =>
				array (
					30 => 55,
					50 => 70,
					100 => 108,
					150 => 144,
					200 => 179,
					250 => 190,
					300 => 200,
				),
				'prazo' => 15,
			),
			'Mato Grosso Sul - Capital' =>
			array (
				'ini' => '79000000',
				'end' => '79124999',
				'opcoes' =>
				array (
					30 => 45,
					50 => 50,
					100 => 70,
					150 => 100,
					200 => 120,
					250 => 150,
					300 => 200,
					350 => 230,
					400 => 240,
				),
				'prazo' => 15,
			),
			'Mato Grosso Sul - Interior' =>
			array (
				'ini' => '79125000',
				'end' => '79999999',
				'opcoes' =>
				array (
					30 => 50,
					50 => 65,
					100 => 99,
					150 => 136,
					200 => 145,
					250 => 170,
					300 => 220,
					350 => 250,
					400 => 280,
				),
				'prazo' => 15,
			),
			'Paran� - Capital' =>
			array (
				'ini' => '80000000',
				'end' => '82999999',
				'opcoes' =>
				array (
					30 => 35,
					50 => 40,
					100 => 55,
					150 => 60,
					200 => 70,
					250 => 75,
					300 => 90,
					350 => 110,
					400 => 160,
				),
				'prazo' => 7,
			),
			'Paran� - Interior' =>
			array (
				'ini' => '83000000',
				'end' => '87999999',
				'opcoes' =>
				array (
					30 => 45,
					50 => 75,
					100 => 65,
					150 => 75,
					200 => 90,
					250 => 1900,
					300 => 120,
					350 => 130,
					400 => 170,
				),
				'prazo' => 10,
			),
			'Santa Catarina - Capital' =>
			array (
				'ini' => '88000000',
				'end' => '88099999',
				'opcoes' =>
				array (
					30 => 35,
					50 => 39,
					100 => 50,
					150 => 60,
					200 => 65,
					250 => 70,
					300 => 90,
					350 => 110,
					400 => 130,
					500 => 150,
				),
				'prazo' => 7,
			),
			'Santa Catarina - Interior' =>
			array (
				'ini' => '88100000',
				'end' => '89999999',
				'opcoes' =>
				array (
					30 => 40,
					50 => 50,
					100 => 70,
					150 => 80,
					200 => 90,
					250 => 95,
					300 => 105,
					350 => 130,
					400 => 145,
					500 => 180,
				),
				'prazo' => 7,
			),
			'Rio Grande do Sul - Capital' =>
			array (
				'ini' => '90000000',
				'end' => '91999999',
				'opcoes' =>
				array (
					30 => 35,
					50 => 40,
					100 => 45,
					150 => 55,
					200 => 90,
				),
				'prazo' => 5,
			),
			'Rio Grande do Sul - Interior' =>
			array (
				'ini' => '92000000',
				'end' => '99999999',
				'opcoes' =>
				array (
					30 => 50,
					50 => 58,
					100 => 69,
					150 => 79,
					200 => 99,
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
		$peso = $peso/1000;
		return $this->_getData($this->_params['cep_destino'],$peso);
	}
}
