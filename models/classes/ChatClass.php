<?php

namespace app\models\classes;

use app\models\databases\Chats;
use app\models\databases\UserChats;
use app\models\User;

class ChatClass
{
    public int $id = -1; // ID чата
    public string $title = ''; // Название чата
    public string $link = ''; // Уникальная ссылка чата
    public int $status = -1; // Статус чата

    public function __construct($chatAsArray){

        if ($chatAsArray == null){
            return;
        }
        $this->id = $chatAsArray["id"];
        $this->title = $chatAsArray["title"];
        $this->link = $chatAsArray["link"];
        $this->status = $chatAsArray["status"];
    }

    /**
     * Finds chat by ID
     *
     * @param $id
     * @return ChatClass
     */
    public static function FindChatByID($id, $status = 0): ChatClass
    {
        if ($status == 0){
            $ChatFromDB = Chats::findOne($id);
            $chat = [
                'id' => $ChatFromDB->attributes["id"],
                'title' => $ChatFromDB->attributes["title"],
                'link' => $ChatFromDB->attributes["link"],
                'status' => 0
            ];
        }
        else{
            $UserFromDB = User::findIdentity($id);
            $chat = [
                'id' => $UserFromDB["id"],
                'title' => $UserFromDB["username"],
                'link' => $UserFromDB["link"],
                'status' => 1
            ];
        }

        return new ChatClass($chat);
    }

    /**
     * Finds chat by Link
     *
     * @param $link
     * @return ChatClass
     */
    public static function FindChatByLink($link, $status = 0): ChatClass
    {
        if ($status == 0) { // Поиск чата
            $ChatFromDB = Chats::find()->where([
                "link" => $link
            ])->one();

            $chat = [
                'id' => $ChatFromDB->attributes["id"],
                'title' => $ChatFromDB->attributes["title"],
                'link' => $link,
                'status' => 0
            ];
        }
        else{ // Поиск пользователя
            $UserFromDB = User::findByLink($link);
            $chat = [
                'id' => $UserFromDB->id,
                'title' => $UserFromDB->username,
                'link' => $link,
                'status' => 1
            ];
        }
        return new ChatClass($chat);
    }

    /**
     * Finds chat by Title
     *
     * @param $title
     * @return ChatClass
     */
    public static function FindChatByTitle($title, $status = 0): ChatClass
    {
        $ChatFromDB = Chats::find()->where([
            "title" => $title
        ])->one();

        if ($status == 0) {
            $chat = [
                'id' => $ChatFromDB->attributes["id"],
                'title' => $ChatFromDB->attributes["title"],
                'link' => $ChatFromDB->attributes["link"],
                'status' => 0
            ];
        }
        else{
            $UserFromDB = User::findByUsername($title);
            $chat = [
                'id' => $UserFromDB["id"],
                'title' => $UserFromDB["username"],
                'link' => $UserFromDB["link"],
                'status' => 1
            ];
        }

        return new ChatClass($chat);
    }

    /**
     * Finds all chats, where user is added
     *
     * @param $UserID
     * @return array
     */
    public static function GetChatsList($UserID) : array{
        $chatsList = UserChats::find()->where(['user_id' => $UserID])->all();
        $chats = [];

        foreach ($chatsList as $CurrChat){
            if ($CurrChat->attributes["status"] == 1) $chat = ChatClass::FindChatByLink($CurrChat->attributes["chat_link"], 1);
            else $chat = ChatClass::FindChatByLink($CurrChat->attributes["chat_link"]);

            array_push($chats, $chat);
        }
        return $chats;
    }

    /**
     * Constructs chat form
     *
     * @param $chat
     * @return string
     */
    public static function ConstructChat($chat){
        $ChatBox = '
        <a href="chat/select?link=' . $chat->link . '">
            <div class="col-lg-4">
                <h2>' . $chat->title . ' (' . $chat->link . ') </h2>';
        if ($chat->status === 1){
            $ChatBox .= '<p>  Директ</p>';
        }
        else{
            $ChatBox .= '<p>  Общий чат</p>';
        }

        $ChatBox .= '</div></a>';

        return $ChatBox;
    }

    public function GetMessages(){

    }
}