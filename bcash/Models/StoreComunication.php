<?php

class App_Models_StoreComunication {

    private $_storeUrl = '';

    public function _construct($storeUrl) {
        $this->setStoreUrl($storeUrl);
    }

    public function setStoreUrl($storeUrl) {
        $this->_storeUrl = $storeUrl;

        return $this;
    }

    public function getStoreUrl() {
        return $this->_storeUrl;
    }

    public function sendMessage() {
        $url = $this->getStoreUrl();
        $data = json_encode($data);
        $params = array('data' => $data,'encode' => $this->getEncode());
        var_dump($params);
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($params));
        curl_setopt($curl,CURLOPT_HTTPHEADER,$this->_getHeader($url));
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
    }
}
