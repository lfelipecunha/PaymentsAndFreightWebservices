<?php

abstract class App_Models_BCashAbstract {

    private $_email;
    private $_token;
    private $_encode;
    private $_consumerKey;

    public function __construct($email,$token,$consumerKey,$encode = 'UTF-8') {
        $this
            ->setEmail($email)
            ->setToken($token)
            ->setEncode($encode)
            ->setConsumerKey($consumerKey)
            ->init();
    }

    public function init() {}

    public function setEncode($encode) {
        $availables = array('UTF-8','ISO-8859-1');
        if (!in_array($encode,$availables)) {
            $encode = reset($encode);
        }
        $this->_encode = $encode;
        return $this;
    }

    public function getEncode() {
        return $this->_encode;
    }

    public function setToken($token) {
        $this->_token = $token;
        return $this;
    }

    public function getToken() {
        return $this->_token;
    }

    public function setEmail($email) {
        $this->_email = $email;
        return $this;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setConsumerKey($consumerKey) {
        $this->_consumerKey = $consumerKey;
        return $this;
    }

    public function getConsumerKey() {
        return $this->_consumerKey;
    }


    abstract protected function _getHeader($url);

    private function _ISO2UTF($data) {
        if (!is_array($data)) {
            return utf8_encode($data);
        }
        foreach ($data as $key => &$value) {
            $value = $this->_ISO2UTF($value);
        }
        return $data;
    }


    protected function _doRequest($method,$data) {
        $url = 'https://api.bcash.com.br/service/'.$method.'/json';
        $data = json_encode($this->_ISO2UTF($data));
        $params = array('data' => $data,'encode' => $this->getEncode());
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($params));
        curl_setopt($curl,CURLOPT_HTTPHEADER,$this->_getHeader($url));
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($response,true);
        if ($httpCode != 200) {
            App_Log::addLog('error','HttpCode:'.$httpCode.' Error: '.$response['list'][0]['code'].' Message: '.urldecode($response['list'][0]['description']).' Params: '.$data);
        }
        return array('response' => $response,'code' => $httpCode);
    }
}
