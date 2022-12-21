<?php
namespace ObxStudios;

class ChatFramework
{
    public const version = "2.0";
    private $userId;
    private $message = '';
    private $token = '';
    private $messageId;
    private $userIdInGroup;
    public $isMessage = false;
    public $isCallback = false;
    public $isGroupChat = false;

    public function __construct($token){
        $rawData = json_decode(file_get_contents("php://input"), TRUE);
        //file_put_contents('read.txt', json_encode($rawData));

        $this->token = $token;

        if (isset($rawData["message"]["chat"]["type"]) && $rawData["message"]["chat"]["type"] == 'group'){
            $this->isGroupChat = true;
            $this->messageId = $rawData["message"]["message_id"];
            $this->userIdInGroup = $rawData["message"]["from"]["id"];
        }
        if (isset($rawData["message"]["text"])){
            $this->userId = $rawData["message"]["chat"]["id"];
            $this->isMessage = true;
            $this->message = $rawData["message"]["text"];
        }else if (isset($rawData['callback_query']['data'])){
            $this->isCallback = true;
            if ($rawData["callback_query"]["message"]['chat']["type"] == 'group'){
                $this->isGroupChat = true;
                $this->userId = $rawData['callback_query']['message']['chat']['id'];
                $this->userIdInGroup = $rawData['callback_query']['from']['id'];
                $this->messageId = $rawData['callback_query']['message']['message_id'];

            }else{
                $this->userId = $rawData['callback_query']['from']['id'];
            }
            

            $this->message = $rawData['callback_query']['data'];
        }
    }

    public function getMessageId(){
        return $this->messageId;
    }

    public function getUserIdInGroup(){
        return $this->userIdInGroup;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function getMessage(){
        return $this->message;
    }

    public function createButton($text, $callbackData){
        return [
            "text" => $text,
            "callback_data" => $callbackData
        ];
    }

    public function createKeyboads($buttons){
        return json_encode([
            "inline_keyboard" => [$buttons]
        ]);
    }

    public function sendTextMessage($userId, $message){
        $data = [
            'chat_id' => $userId,
            'text' => $message
        ];
        if ($this->isGroupChat && !empty($this->messageId))
            $data['reply_to_message_id'] = $this->messageId;
        return file_get_contents("https://api.telegram.org/bot{$this->token}/sendMessage?" . http_build_query($data));
    }

    public function sendReplyMarkup($userId, $text, $keyboard)
    {
        $data = [
            'chat_id' => $userId,
            'text' => $text
        ];
        if ($this->isGroupChat && !empty($this->messageId))
            $data['reply_to_message_id'] = $this->messageId;
        return file_get_contents("https://api.telegram.org/bot{$this->token}/sendMessage?" . http_build_query($data). "&reply_markup={$keyboard}");

    }
}