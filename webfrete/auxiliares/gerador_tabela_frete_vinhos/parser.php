<?php
$file =  file_get_contents('frete.csv');
$lines = explode("\n",$file);
$firstLine = array_shift($lines);
$columns = explode("\t",$firstLine);
foreach ($columns as &$column) {
    $column = strtolower($column);
}
$data = array();
$pesos = array(30,50,100,150,200,250,300,350,400,410,450,470,500,520,550,600);
foreach ($lines as $region) {
    $region = trim($region);
    if (empty($region)) {
        continue;
    }
    $infos = explode("\t",$region);
    reset($columns);
    $aux = array();
    foreach ($infos as $info) {
        $aux[current($columns)] = $info;
        next($columns);
    }
    $key = $aux['regiao'];
    $data[$key] = array(
        'ini' => preg_replace('/[^0-9]/','',$aux['cepinicio']),
        'end' => preg_replace('/[^0-9]/','',$aux['cepfim']),
        'opcoes' => array(),
        'prazo' => (int)$aux['prazo'],
    );
    foreach ($pesos as $peso) {
        if (!empty($aux[$peso]) && $aux[$peso] != '-') {
            $data[$key]['opcoes'][$peso] = (float)$aux[$peso];
        }
    }
}
var_export($data);


