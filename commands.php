<?php
$command = strtolower($bot->getMessage());

switch ($command) {
    case '/start':
        if (!$userData['inProcessing']) {
            $userData = [
                'step' => (!empty($userData['data'][0])) ? 1 : 0,
                'data' => (!empty($userData['data'][0])) ? [$userData['data'][0]] : [],
                'inProcessing' => true
            ];
            updateData($key_update, $userData);
        } else {
            $bot->sendTextMessage($userId, _RESET_IT);
            exit();
        }
        break;
    case '/reset':
        $userData = [
            'step' => (!empty($userData['data'][0])) ? 1 : 0,
            'data' => (!empty($userData['data'][0])) ? [$userData['data'][0]] : [],
            'inProcessing' => true
        ];
        updateData($key_update, $userData);
        break;
    case '/clear':
        $userData = [
            'step' => (!empty($userData['data'][0])) ? 1 : 0,
            'data' => (!empty($userData['data'][0])) ? [$userData['data'][0]] : [],
            'inProcessing' => false
        ];
        updateData($key_update, $userData);
        $bot->sendTextMessage($userId, _CLEAR_QUEUE);
        break;
    case '/cleardb':
        $userData = [
            'step' => (!empty($userData['data'][0])) ? 1 : 0,
            'data' => (!empty($userData['data'][0])) ? [$userData['data'][0]] : [],
            'inProcessing' => false
        ];
        updateData($key_update, $userData);
        if ($conn->QUERY("DELETE FROM `bangKhaoSat`"))
            $bot->sendTextMessage($userId, "Database cleared");
        else
            $bot->sendTextMessage($userId, _SOMETHING_WENT_WRONG);
        break;
    case '/restart':
        $userData = [
            'step' => 0,
            'data' => [],
            'inProcessing' => false
        ];
        updateData($key_update, $userData);
        $bot->sendTextMessage($userId, _CLEAR_QUEUE);
        break;
    case '/help':
        $bot->sendTextMessage($userId, "[BOT]\n - /start: B???t ?????u\n - /reset: Reset l???i\n - /clear: X??a d??? li???u ??ang nh???p\n - /restart: Kh???i t???o l???i phi??n (Nh???p l???i t??n)\n - /devmode: Ch??? ????? ph??t tri???n");
        break;
    case '/devmode':
        if ($bot->isGroupChat){
            $bot->sendTextMessage($userId, "[DEVELOP MODE]\nType: Group Chat\nGroup ID: $userId\nUser ID: {$bot->getUserIdInGroup()}\nFILE DATA: $key_update");
        }else{
            $bot->sendTextMessage($userId, "[DEVELOP MODE]\nType: Private\nUser ID: $userId\nFILE DATA: $key_update");
        }
        break;
    case '/calendar': 
        $bot->sendTextMessage($userId, _CALENDAR);
        break;
    default:
        $bot->sendTextMessage($userId, _UNKNOWN_COMMAND);
        break;
}
