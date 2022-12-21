<?php
switch ($userData['step']) {
    case 0:
        $bot->sendTextMessage($userId, _INPUT_DATA['step'][0]);
        $bot->sendTextMessage($userId, _INPUT_DATA['step'][1]);
        
        $userData['step'] = 1;
        break;
    case 1:
        $bot->sendTextMessage($userId, _INPUT_DATA['step'][2]);
        $userData['step'] = 2;
        $userData['data'][0] = (!empty($userData['data'][0])) ? $userData['data'][0] : $bot->getMessage();
        break;
    case 2:
        $keyboard = $bot->createKeyboads(
            [
                $bot->createButton(_YES, _OPTION['yes']),
                $bot->createButton(_NO, _OPTION['no']),
            ]
        );
        $bot->sendReplyMarkup(
            $userId,
            _INPUT_DATA['step'][3],
            $keyboard
        );

        $userData['step'] = 3;
        $userData['data'][1] = $bot->getMessage();
        break;
    case 3:
        if ($bot->isMessage) {
            $bot->sendTextMessage($userId, _ERROR_SELECT_OPTION);
        } else {
            $userData['step'] = 4;
            $userData['data'][2] = empty($bot->getMessage()) ? '' : $bot->getMessage();
            // Insert data to database
            $userData['data'][0] = $conn->real_escape_string($userData['data'][0]);
            $userData['data'][1] = $conn->real_escape_string($userData['data'][1]);
            $userData['data'][2] = $conn->real_escape_string($userData['data'][2]);


            $updateByID = $bot->isGroupChat ? $bot->getUserIdInGroup() : $bot->getUserId();

            $checkIfIsset = $conn->QUERY("SELECT * FROM `bangKhaoSat` WHERE teleID = '$updateByID'");

            $date = date('d/m/Y H:i:s', time());

            if ($checkIfIsset->num_rows != 0)
                $check = $conn->QUERY("UPDATE `bangKhaoSat` SET Name = '{$userData['data'][0]}', Food = '{$userData['data'][1]}', q3 = '{$userData['data'][2]}', timeAns = '$date' WHERE teleID = '$updateByID'");
            else
                $check = $conn->QUERY("INSERT INTO `bangKhaoSat` (teleID, Name, Food, q3, timeAns) VALUES ('$updateByID', '{$userData['data'][0]}', '{$userData['data'][1]}', '{$userData['data'][2]}', '$date')");
            if ($check){
                $bot->sendTextMessage($userId, _INPUT_DATA['step'][4]);
            } else {
                $bot->sendTextMessage($userId, _ERROR_DATABASE_CONNECT);
            }
            $userData = [
                'step' => (!empty($userData['data'][0])) ? 1 : 0,
                'data' => (!empty($userData['data'][0])) ? [$userData['data'][0]] : [],
                'inProcessing' => false
            ];
        }
        break;
    default:
        $bot->sendTextMessage($userId, str_replace('{0}', 'inputdata (step invalid)', _SOMETHING_WENT_WRONG));

        $userData = [
            'step' => (!empty($userData['data'][0])) ? 1 : 0,
            'data' => (!empty($userData['data'][0])) ? [$userData['data'][0]] : [],
            'inProcessing' => false
        ];
        break;
}
updateData($key_update, $userData);