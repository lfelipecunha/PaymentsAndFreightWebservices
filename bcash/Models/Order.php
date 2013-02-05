<?php

class App_Models_Order extends App_Models_BCashAbstract {

    public function insert($order) {
        $buyer = $order['valores']['comprador'];
        $payment = $order['valores']['pagamento'];
        $products = $order['valores']['produtos'];
        $address = $order['valores']['comprador']['endereco'];
        $card = $order['valores']['pagamento']['cartao'];
        $data = array(
            'sellerMail' => $this->getEMail(),
            'orderId' => $order['id'],
            'buyer' => array(
                'mail' => $buyer['email'],
                'name' => $buyer['nome'],
                'cpf' => $buyer['cpf'],
                // @todo verificar regras para telefone
                'phone' => $buyer['telefone'],

                'gender' => $buyer['genero'],
                'address' => array(
                    'address' => $address['logradouro'],
                    'number' => $address['numero'],
                    'complement' => $address['complemento'],
                    'neighborhood' => $address['bairro'],
                    'city' => $address['cidade'],
                    'state' => $address['estado'],
                    'zipCode' => $address['cep'],
                ),
            ),
            'paymentMethod' => array(
                'code' => $payment['codigo'],
            ),
            'installments' => $payment['parcelas'],
            'creditCard' => array(
                'holder' => $card['titular'],
                'number' => $card['numero'],
                'securityCode' => $card['codigoSeguranca'],
                'maturityMonth' => $card['mesVencimento'],
                'maturityYear' => $card['anoVencimento'],
            ),
            'currency' => 'BRL',
            'acceptedContract' => 'S',
            'viewedContract' => 'S',
        );
        foreach ($products as $product) {
            $data['products'][] = array(
                'code' => $product['codigo'],
                'description' => $product['nome'],
                'amount' => $product['quantidade'],
                'value' => $product['valor'],
            );
        }
        $result = $this->_doRequest('createTransaction',$data);
        return $result;
    }

    private function _getSignature($nonce,$time) {
        $signature = array(
            'oauth_consumer_key' => $this->getConsumerKey(),
            'oauth_nonce' => $nonce,
            'oauth_signature_method'=> 'PLAINTEXT',
            'oauth_timestamp' => $time,
            'oauth_version' => '1.0',
        );
        return base64_encode(http_build_query($signature,'','&'));
    }

    protected function _getHeader($url) {
        $time = time()*1000;
        $nonce = md5(microtime().mt_rand());
        $token = $this->getToken();
        $signature = $this->_getSignature($nonce,$time);
        $data = 'Authorization: OAuth realm=https://api.pagamentodigital.com.br/checkout/json/'.
            ',oauth_consumer_key='.$this->getConsumerKey().
            ',oauth_nonce='.$nonce.
            ',oauth_signature='. $signature.
            ',oauth_signature_method=PLAINTEXT'.
            ',oauth_timestamp='.$time.
            ',oauth_version=1.0';

        $headers = array(
            $data,
            'Content-type:application/x-www-form-urlencoded;charset='.$this->getEncode()
        );
        return $headers;
    }
}
