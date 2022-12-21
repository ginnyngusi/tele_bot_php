<?php
define('_PATH_DATA', $_SERVER['DOCUMENT_ROOT']. '/data/'); // Config forlder chứa data

function getData($key){
    $rawData = json_decode(utf8_encode(file_get_contents(_PATH_DATA. 'input_'. $key. '.json')), TRUE);
    return $rawData;
}

function updateData($key, $data){
    file_put_contents(_PATH_DATA . 'input_' . $key . '.json', json_encode($data));
}

function checkIsset($key){
    return file_exists(_PATH_DATA . 'input_' . $key . '.json');
}