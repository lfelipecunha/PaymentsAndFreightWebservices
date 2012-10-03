<?php

class Application_Model_VinhosESabores implements Application_Model_Frete
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
				30 => 35,
				50 => 35,
				100 => 45,
				150 => 45,
				200 => 49,
				250 => 55,
				300 => 75,
				350 => 90,
				450 => 120,
				520 => 150,
			),
			'prazo' => 7,
		),
		'São Paulo - Interior' =>
		array (
			'ini' => '06000000',
			'end' => '19999999',
			'opcoes' =>
			array (
				30 => 49,
				50 => 49,
				100 => 49,
				150 => 49,
				200 => 60,
				250 => 80,
				300 => 90,
				350 => 100,
				410 => 190,
				470 => 220,
			),
			'prazo' => 10,
		),
		'Rio de Janeiro - Capital ' =>
		array (
			'ini' => '20000000',
			'end' => '23799999',
			'opcoes' =>
			array (
				30 => 37,
				50 => 39,
				100 => 40,
				150 => 42,
				200 => 49,
				250 => 50,
				300 => 65,
				350 => 75,
				400 => 95,
				450 => 102,
				500 => 102,
				550 => 120,
			),
			'prazo' => 7,
		),
		'Rio de Janeiro - Interior' =>
		array (
			'ini' => '23800000',
			'end' => '28999999',
			'opcoes' =>
			array (
				30 => 45,
				50 => 59,
				100 => 69,
				150 => 89,
				200 => 99,
				250 => 109,
				300 => 119,
				350 => 129,
				400 => 139,
				450 => 149,
				500 => 159,
				550 => 180,
			),
			'prazo' => 10,
		),
		'Espírito Santo - Capital' =>
		array (
			'ini' => '29000000',
			'end' => '29099999',
			'opcoes' =>
			array (
				30 => 55,
				50 => 70,
				100 => 80,
				150 => 100,
				200 => 120,
				250 => 129,
				300 => 159,
			),
			'prazo' => 15,
		),
		'Espírito Santo - Interior' =>
		array (
			'ini' => '29100000',
			'end' => '29999999',
			'opcoes' =>
			array (
				30 => 45,
				50 => 60,
				100 => 70,
				150 => 95,
				200 => 102,
				250 => 110,
				300 => 140,
				350 => 159,
			),
			'prazo' => 15,
		),
		'Minas Gerais - Capital' =>
		array (
			'ini' => '30000001',
			'end' => '31999999',
			'opcoes' =>
			array (
				30 => 40,
				50 => 45,
				100 => 45,
				150 => 45,
				200 => 70,
				250 => 75,
				300 => 90,
				350 => 130,
                400 => 150,
                450 => 170,
                500 => 200,
                550 => 250,
                600 => 290,
			),
			'prazo' => 7,
		),

		'Minas Gerais - Interior ' =>
		array (
			'ini' => '32000000',
			'end' => '39999999',
			'opcoes' =>
			array (
				30 => 45,
				50 => 48,
				100 => 48,
				150 => 55,
				200 => 70,
				250 => 90,
				300 => 90,
				350 => 140,
                400 => 175,
                450 => 195,
                500 => 220,
                550 => 290,
                600 => 310,
			),
			'prazo' => 10,
		),
		'Bahia - Capital' =>
		array (
			'ini' => '40000000',
			'end' => '42499999',
			'opcoes' =>
			array (
				30 => 50,
				50 => 65,
				100 => 100,
				150 => 150,
				200 => 170,
			),
			'prazo' => 15,
		),
		'Bahia - Interior' =>
		array (
			'ini' => '42500000',
			'end' => '48999999',
			'opcoes' =>
			array (
				30 => 60,
				50 => 75,
				100 => 120,
				150 => 150,
				200 => 170,
			),
			'prazo' => 15,
		),
		'Sergipe - Capital' =>
		array (
			'ini' => '49000000',
			'end' => '49098999',
			'opcoes' =>
			array (
				30 => 54,
				50 => 70,
				100 => 110,
				150 => 150,
				200 => 175,
			),
			'prazo' => 15,
		),
		'Sergipe - Interior' =>
		array (
			'ini' => '49099000',
			'end' => '49999999',
			'opcoes' =>
			array (
				30 => 64,
				50 => 82,
				100 => 126,
				150 => 150,
				200 => 175,
			),
			'prazo' => 15,
		),
		'Pernambuco - Capital' =>
		array (
			'ini' => '50000000',
			'end' => '52999999',
			'opcoes' =>
			array (
				30 => 51,
				50 => 65,
				100 => 59,
				150 => 159,
				200 => 199,
			),
			'prazo' => 15,
		),
		'Pernambuco - Interior' =>
		array (
			'ini' => '53000000',
			'end' => '56999999',
			'opcoes' =>
			array (
				30 => 61,
				50 => 80,
				100 => 115,
				150 => 199,
			),
			'prazo' => 15,
		),
		'Alagoas - Capital' =>
		array (
			'ini' => '57000000',
			'end' => '57099999',
			'opcoes' =>
			array (
				30 => 55,
				50 => 70,
				100 => 110,
				150 => 150,
				200 => 220,
			),
			'prazo' => 15,
		),
		'Alagoas - Interior' =>
		array (
			'ini' => '57100000',
			'end' => '57999999',
			'opcoes' =>
			array (
				30 => 65,
				50 => 80,
				100 => 125,
				150 => 150,
				200 => 220,
			),
			'prazo' => 15,
		),
		'Paraiba - Capital' =>
		array (
			'ini' => '58000000',
			'end' => '58099999',
			'opcoes' =>
			array (
				30 => 71,
				50 => 85,
				100 => 120,
				150 => 180,
				200 => 250,
			),
			'prazo' => 15,
		),
		'Paraiba - Interior' =>
		array (
			'ini' => '58100000',
			'end' => '58999999',
			'opcoes' =>
			array (
				30 => 85,
				50 => 105,
				100 => 150,
				150 => 190,
				200 => 250,
			),
			'prazo' => 15,
		),
		'Rio Grande do Norte - Capital' =>
		array (
			'ini' => '59000000',
			'end' => '59139999',
			'opcoes' =>
			array (
				30 => 72,
				50 => 89,
				100 => 125,
				150 => 179,
				200 => 229,
			),
			'prazo' => 15,
		),
		'Rio Grande do Norte - Interior' =>
		array (
			'ini' => '59140000',
			'end' => '59999999',
			'opcoes' =>
			array (
				30 => 84,
				50 => 101,
				100 => 147,
				150 => 169,
				200 => 199,
			),
			'prazo' => 15,
		),
		'Ceará - Capital' =>
		array (
			'ini' => '60000000',
			'end' => '61599999',
			'opcoes' =>
			array (
				30 => 75,
				50 => 91,
				100 => 135,
				150 => 160,
				200 => 200,
			),
			'prazo' => 15,
		),
		'Ceará - Interior' =>
		array (
			'ini' => '61600000',
			'end' => '63999999',
			'opcoes' =>
			array (
				30 => 85,
				50 => 105,
				100 => 150,
				150 => 190,
				200 => 250,
			),
			'prazo' => 15,
		),
		'Piaui - Capital' =>
		array (
			'ini' => '64000000',
			'end' => '64099999',
			'opcoes' =>
			array (
				30 => 80,
				50 => 95,
				100 => 140,
				150 => 190,
				200 => 230,
			),
			'prazo' => 15,
		),
		'Piaui - Interior' =>
		array (
			'ini' => '64100000',
			'end' => '64999999',
			'opcoes' =>
			array (
				30 => 85,
				50 => 105,
				100 => 150,
				150 => 190,
				200 => 249,
			),
			'prazo' => 15,
		),
		'Maranhão - Capital' =>
		array (
			'ini' => '65000001',
			'end' => '65109999',
			'opcoes' =>
			array (
				30 => 80,
				50 => 100,
				100 => 150,
				150 => 199,
				200 => 250,
			),
			'prazo' => 15,
		),
		'Maranhão - Interior' =>
		array (
			'ini' => '65110000',
			'end' => '65999999',
			'opcoes' =>
			array (
				30 => 90,
				50 => 115,
				100 => 165,
				150 => 199,
				200 => 250,
			),
			'prazo' => 15,
		),
		'Pará - Capital' =>
		array (
			'ini' => '66000000',
			'end' => '66999999',
			'opcoes' =>
			array (
				30 => 155,
				50 => 165,
				100 => 219,
				150 => 245,
				200 => 325,
			),
			'prazo' => 15,
		),
		'Pará - Interior' =>
		array (
			'ini' => '67000000',
			'end' => '68899999',
			'opcoes' =>
			array (
				30 => 155,
				50 => 165,
				100 => 209,
				150 => 245,
				200 => 325,
			),
			'prazo' => 15,
		),
		'Amazonas - Capital' =>
		array (
			'ini' => '69000000',
			'end' => '69290999',
			'opcoes' =>
			array (
				30 => 180,
				50 => 210,
				100 => 250,
				150 => 290,
				200 => 376,
				250 => 490,
				300 => 590,
			),
			'prazo' => 15,
		),
		'Amazonas - Interior' =>
		array (
			'ini' => '69400000',
			'end' => '69899999',
			'opcoes' =>
			array (
				30 => 180,
				50 => 210,
				100 => 250,
				150 => 290,
				200 => 350,
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
				30 => 170,
				50 => 190,
				100 => 200,
				150 => 220,
				200 => 260,
				300 => 300,
			),
			'prazo' => 15,
		),
		'Acre - Interior' =>
		array (
			'ini' => '69991000',
			'end' => '69999999',
			'opcoes' =>
			array (
				30 => 170,
				50 => 190,
				100 => 200,
				150 => 220,
				200 => 270,
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
				50 => 40,
				100 => 45,
				150 => 60,
				200 => 80,
			),
			'prazo' => 15,
		),
		'Goias - Interior' =>
		array (
			'ini' => '72800000',
			'end' => '72999999',
			'opcoes' =>
			array (
				30 => 59,
				50 => 65,
				100 => 90,
				150 => 129,
				200 => 130,
				250 => 159,
				300 => 199,
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
				100 => 55,
				150 => 60,
				200 => 80,
			),
			'prazo' => 15,
		),
		'Goias - Capital / Aparecida' =>
		array (
			'ini' => '73700000',
			'end' => '76799999',
			'opcoes' =>
			array (
				30 => 49,
				50 => 56,
				100 => 80,
				150 => 103,
				200 => 120,
				250 => 140,
				300 => 190,
			),
			'prazo' => 15,
		),
		'Rondonia - Capital' =>
		array (
			'ini' => '76800000',
			'end' => '76834999',
			'opcoes' =>
			array (
				30 => 99,
				50 => 109,
				100 => 139,
				150 => 185,
				200 => 231,
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
				50 => 85,
				100 => 119,
				150 => 165,
				200 => 211,
			),
			'prazo' => 15,
		),
		'Tocantins - Capital' =>
		array (
			'ini' => '77000000',
			'end' => '77249999',
			'opcoes' =>
			array (
				30 => 50,
				50 => 60,
				100 => 90,
				150 => 99,
				200 => 99,
			),
			'prazo' => 15,
		),
		'Tocantins - Interior' =>
		array (
			'ini' => '77250000',
			'end' => '77999999',
			'opcoes' =>
			array (
				30 => 51,
				50 => 62,
				150 => 99,
				200 => 120,
			),
			'prazo' => 15,
		),
		'Mato Grosso - Capital' =>
		array (
			'ini' => '78000000',
			'end' => '78099999',
			'opcoes' =>
			array (
				30 => 92,
				50 => 103,
				100 => 137,
				150 => 154,
				200 => 189,
			),
			'prazo' => 15,
		),
		'Mato Grosso - Interior' =>
		array (
			'ini' => '78100000',
			'end' => '78899999',
			'opcoes' =>
			array (
				30 => 92,
				50 => 103,
				100 => 127,
				150 => 144,
				200 => 179,
			),
			'prazo' => 15,
		),
		'Mato Grosso Sul - Capital ' =>
		array (
			'ini' => '79000000',
			'end' => '79124999',
			'opcoes' =>
			array (
				30 => 70,
				50 => 80,
				100 => 100,
				150 => 126,
				200 => 155,
			),
			'prazo' => 15,
		),
		'Mato Grosso Sul - Interior' =>
		array (
			'ini' => '79125000',
			'end' => '79999999',
			'opcoes' =>
			array (
				30 => 70,
				50 => 79,
				100 => 99,
				150 => 136,
			),
			'prazo' => 15,
		),
		'Paraná - Capital ' =>
		array (
			'ini' => '80000000',
			'end' => '82999999',
			'opcoes' =>
			array (
				30 => 40,
				50 => 45,
				100 => 45,
				150 => 45,
				200 => 55,
			),
			'prazo' => 7,
		),
		'Paraná - Interior' =>
		array (
			'ini' => '83000000',
			'end' => '87999999',
			'opcoes' =>
			array (
				30 => 40,
				50 => 45,
				100 => 45,
				150 => 55,
				200 => 70,
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
				100 => 39,
				150 => 44,
				200 => 55,
                250 => 60,
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
				30 => 35,
				50 => 40,
				100 => 49,
				150 => 55,
				200 => 60,
                250 => 70,
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
				30 => 25,
				50 => 25,
				100 => 25,
				150 => 77,
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
