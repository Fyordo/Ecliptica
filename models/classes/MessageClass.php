<?php


namespace app\models\classes;


use app\models\databases\Messages;
use app\models\User;

class MessageClass
{
    public int $id; // ID сообщения
    public string $user; // Link отправителя
    public string $username; // Ник отправителя
    public string $text; // Текст сообщения
    public string $time; // Время отправки
    public string $chatLink; // Link диалога

    public function __construct($message){

        if ($message == null){
            return;
        }

        $this->id = $message["id"];
        $this->user = $message["user"];
        $this->username = $message["username"];
        $this->text = $message["text"];
        $this->time = $message["time"];
        $this->chatLink = $message["chatLink"];
    }

    /**
     * Находит все сообщения из чата ChatLink
     *
     * @param $chatLink
     * @return array
     */
    public static function FindMessagesFromChat($chatLink): array
    {
        $MessagesFromDB = Messages::find()->where([
            "chatlink" => $chatLink
        ])->all();

        $messages = [];

        foreach ($MessagesFromDB as $message){
            $message = [
                'id' => $message->attributes["id"],
                'user' => $message->attributes["user"],
                'username' => User::findByLink($message->attributes["user"])->username,
                'text' => $message->attributes["text"],
                'time' => $message->attributes["time"],
                'chatLink' => $chatLink
            ];

            array_push($messages, new MessageClass($message));
        }

        return $messages;
    }

    /**
     * Сделать форму с сообщениями
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
            return '<h3 align="center">Здесь пока нет сообщений</h3><br>';
        }

        return $MessagesBox;
    }
}