<?php


namespace app\models\classes;


use app\models\databases\Chats;
use app\models\databases\Messages;
use app\models\User;
use Yii;

class MessageClass
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
                'userlink' => $message->attributes["userlink"],
                'username' => $message->attributes["username"],
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
            return '<h3 id="nomess" align="center">Здесь пока нет сообщений</h3><br>';
        }

        return $MessagesBox;
    }

    private static function GetLastID(){
        $lastMessage = Messages::find()->orderBy(['id' => SORT_DESC])->one();
        return $lastMessage->attributes["id"];
    }

    public static function AddMessage($chatlink, $text, $time){
        $message = new Messages();
        $user = Yii::$app->user->identity;
        $message->id = self::GetLastID()+1;
        $message->userlink = $user->link;
        $message->username = $user->username;
        $message->text = $text;
        $message->time = $time;
        $message->chatlink = $chatlink;
        $message->save();

    }
}