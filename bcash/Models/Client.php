<?php

class App_Models_Client extends App_Models_BCashAbstract {

    public function insert($identifier) {
      $data = array('cpf' => '01502481057');
      var_dump($this->_doRequest('searchAccount',$data));die;

        $data = array(
            'owner' => array(
                'email' => 'felipe.silvacunha@gmail.com.br',
                'gender' => 'M',
                'name' => 'Luiz Felipe Cunha',
                'cpf' => '01502481057',
                'brithDate' => '01/09/1988',
            ),
            'address' => array(
                'address' => 'Av. Unisinos',
                'number' => '950',
                'complement' => 'prédio pe rick',
                'neighborhood' => 'Cristo Rei',
                'city' => 'São Leopoldo',
                'state' => 'RS',
                'zipCode' => '93022000',
            ),
            'contact' => array(
                'phoneNumber' => '5185684976',
            ),
        );
        var_dump($this->_doRequest('createAccount',$data));die;
    }

    protected function _getHeader($url) {
        $email = $this->getEmail();
        $token = $this->getToken();
        return array('Authorization: Basic '.base64_encode($email.':'.$token));
    }

}
