<?php

class Application_Model_FreteGratis implements Application_Model_Frete {

    protected $_cepDestino;

    protected $_prazo;

    protected $_faixasCep = array();


    public function __construct($params,$opcao) {
        $this->_cepDestino = $params['cep_destino'];
        $this->_prazo = (int)$opcao['prazo_entrega'];
        $this->_makeFaixasCep($opcao['faixas_cep']);
    }

    protected function _makeFaixasCep($faixas) {
        $lines = explode("\n",$faixas);
        foreach ($lines as $line) {
            $line = trim($line);
            $range = explode(';',$line);
            if (count($range) < 2) {
                continue;
            }
            $this->_faixasCep[] = array(
                'ini' => preg_replace('/[^0-9]/','',$range[0]),
                'end' => preg_replace('/[^0-9]/','',$range[1]),
            );
        }
    }

    public function consulta() {
        foreach ($this->_faixasCep as $faixa) {
            if ($this->_cepDestino >= $faixa['ini'] && $this->_cepDestino <= $faixa['end']) {
                return array(
                    'prazo' => $this->_prazo,
                    'valor' => 0,
                    'erro' => 0,
                );
            }
        }
        return array('prazo' => 0,'valor' => 0,'erro' => 1);

    }
}
