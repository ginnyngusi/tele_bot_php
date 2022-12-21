<?php

/* For development 
*/
ini_set('display_errors', 1);
$_SERVER['DOCUMENT_ROOT'] =  $_SERVER['DOCUMENT_ROOT'] . '/demo_bot';


require_once $_SERVER["DOCUMENT_ROOT"] . '/autoload/ChatFramework.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/autoload/functions.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/config.php'; // Phần database
require_once $_SERVER["DOCUMENT_ROOT"] . '/vi_VN.php';

$bot = new \ObxStudios\ChatFramework($tokenBot); // Update token trong file config. Từ giờ về sau sao lưu file config, không cần quan tâm mỗi khi update bot
$userId = $bot->getUserId();

// Get data user
$key_update = $bot->isGroupChat ? $bot->getUserIdInGroup() : $userId;

if (checkIsset($key_update)) {
    $userData = getData($key_update);
} else {
    $userData = [
        'step' => 0,
        'data' => [],
        'inProcessing' => false
    ];
    updateData($key_update, $userData);
}

if (isset($bot->getMessage()[0]) && $bot->getMessage()[0] == '/') 
    require_once $_SERVER["DOCUMENT_ROOT"] . '/commands.php';


if (isset($userData['inProcessing']) && $userData['inProcessing'])
    require_once $_SERVER["DOCUMENT_ROOT"] . '/inputdata.php';
