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
        $bot->sendTextMessage($userId, "[BOT]\n - /start: Bắt đầu\n - /reset: Reset lại\n - /clear: Xóa dữ liệu đang nhập\n - /restart: Khởi tạo lại phiên (Nhập lại tên)\n - /devmode: Chế độ phát triển");
        break;
    case '/devmode':
        if ($bot->isGroupChat){
            $bot->sendTextMessage($userId, "[DEVELOP MODE]\nType: Group Chat\nGroup ID: $userId\nUser ID: {$bot->getUserIdInGroup()}\nFILE DATA: $key_update");
        }else{
            $bot->sendTextMessage($userId, "[DEVELOP MODE]\nType: Private\nUser ID: $userId\nFILE DATA: $key_update");
        }
        break;
    case '/calendar': 
        $bot->sendTextMessage($userID, $date);
        break;
    default:
        $bot->sendTextMessage($userId, _UNKNOWN_COMMAND);
        break;
}
