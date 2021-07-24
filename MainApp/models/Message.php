<?php


namespace app\models;


use app\models\DbModels\Messages;
use Yii;

class Message
{
    public int $id; // ID сообщения
    public string $userlink; // Link отправителя
    public string $username; // Ник отправителя
    public string $text; // Текст сообщения
    public string $time; // Время отправки
    public string $chatLink; // Link диалога

    public function __construct($message){

        if ($message == null){
            return;
        }

        $this->id = $message["id"];
        $this->userlink = $message["userlink"];
        $this->username = $message["username"];
        $this->text = $message["text"];
        $this->time = $message["time"];
        $this->chatLink = $message["chatLink"];
    }

    /**
     * Вывести все сообщения
     *
     * @param $messages
     * @return string
     *
     */
    public static function ConstructMessagesBox($messages){
        $MessagesBox = '';

        foreach ($messages as $message){
            $MessagesBox .= '<h3 align="left">' . $message->username . ' (' . $message->time . ')' . '</h3><h4>' . $message->text . '</h3><br>';
        }

        if (count($messages) == 0){
            return '<h3 id="nomess" align="center">Здесь пока нет сообщений</h3><br>';
        }

        return $MessagesBox;
    }


}