<?php

namespace app\controllers;

use app\models\DbModels\Messages;
use app\models\Message;
use Yii;
use yii\base\BaseObject;

class MessageController extends \yii\web\Controller
{
    /**
     * Находит все сообщения из чата
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

            array_push($messages, new Message($message));
        }

        return $messages;
    }

    /**
     * Вернуть последний ID сообщения из БД
     *
     * @return mixed
     */
    private static function GetLastID(){
        $lastMessage = Messages::find()->orderBy(['id' => SORT_DESC])->one();
        return $lastMessage->attributes["id"];
    }

    /**
     * Отправить сообщение и добавить в БД
     *
     * @param $chatlink
     * @param $text
     * @param $time
     * @param null $user
     */
    public static function AddMessage($chatlink, $text, $time, $user = null){
        $message = new Messages();
        $user = $user == null ? Yii::$app->user->identity : $user;
        $message->id = self::GetLastID()+1;
        $message->userlink = $user->link;
        $message->username = $user->username;
        $message->text = $text;
        $message->time = $time;
        $message->chatlink = $chatlink;
        $message->save();

    }
}
