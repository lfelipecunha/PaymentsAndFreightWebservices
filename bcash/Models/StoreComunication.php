<?php

class App_Models_StoreComunication {

    private $_storeUrl = '';

    public function __construct($storeUrl) {
        $this->setStoreUrl($storeUrl);
    }

    public function setStoreUrl($storeUrl) {
        $this->_storeUrl = $storeUrl;

        return $this;
    }

    public function getStoreUrl() {
        return $this->_storeUrl;
    }

    public function sendMessage($data) {
        $url = $this->getStoreUrl();
        $data = json_encode($data);
        $params = array('data' => $data);
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($params));
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        var_dump($httpCode);var_dump($response);
        curl_close($curl);
        return $httpCode == '200';

    }
}
