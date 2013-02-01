<?php
define('APP_PATH',realpath(dirname(__FILE__)));
define('DS',DIRECTORY_SEPARATOR);
require_once 'loader.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $response = array('O acesso a este serviço é somente por POST');
} else {
    $container = new App_Models_Containers_Order();
    $data = $_POST;
    if (!$container->isValid($data)) {
        $response = array('code' => 0,'errors' => $container->getInvalidFields());
    } else {
        $info = $container->getValues();
        $model = new App_Models_DbTable_Order();
        $id = $model->insert(array('valores' => $info));
        $response = array('code' => $id,'message' => 'Em processo de pagamento');
    }
}

header('Content-Type: application/json');
echo json_encode($response);



