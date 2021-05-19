<?php

namespace app\models\classes;

use app\models\databases\Chats;
use app\models\databases\UserChats;
use app\models\User;
use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\base\BaseObject;
use yii\debug\panels\EventPanel;

class ChatClass
{
    public int $id = -1; // ID чата
    public string $title = ''; // Название чата
    public string $link = ''; // Уникальная ссылка чата

    public function __construct($chatAsArray){

        if ($chatAsArray["id"] == null){
            return;
        }
        $this->id = $chatAsArray["id"];
        $this->title = $chatAsArray["title"];
        $this->link = $chatAsArray["link"];
    }

    /**
     * Находит чат по ID
     *
     * @param $id
     * @return ChatClass
     */
    public static function FindChatByID($id): ChatClass
    {
        $ChatFromDB = Chats::findOne($id);
        $chat = [
            'id' => $ChatFromDB->attributes["id"],
            'title' => $ChatFromDB->attributes["title"],
            'link' => $ChatFromDB->attributes["link"],
        ];

        return new ChatClass($chat);
    }

    /**
     * Finds chat by Link
     *
     * @param $link
     * @return ChatClass|null
     */
    public static function FindChatByLink($link): ChatClass
    {
        $ChatFromDB = Chats::find()->where([
            "link" => $link
        ])->one();

        $chat = [
            'id' => $ChatFromDB->attributes["id"],
            'title' => $ChatFromDB->attributes["title"],
            'link' => $link,
            'status' => 0
        ];
        return new ChatClass($chat);
    }

    /**
     * Finds chat by Title
     *
     * @param $title
     * @return ChatClass
     */
    public static function FindChatByTitle($title): ChatClass
    {
        $ChatFromDB = Chats::find()->where([
            "title" => $title
        ])->one();

        $chat = [
            'id' => $ChatFromDB->attributes["id"],
            'title' => $ChatFromDB->attributes["title"],
            'link' => $ChatFromDB->attributes["link"],
            'status' => 0
        ];

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
            if ($CurrChat->attributes["status"] == 1) $chat = ChatClass::FindChatByLink($CurrChat->attributes["chat_link"]);
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
        <div class="col-lg-4">
            <a href="chat/select?link=' . $chat->link . '">
                    <h2>' . $chat->title . ' (' . $chat->link . ') </h2>
            </a>
            
        </div>
        ';

        return $ChatBox;
    }

    private static function GetLastID(){
        $lastChat = Chats::find()->orderBy(['id' => SORT_DESC])->one();
        return $lastChat->attributes["id"];
    }

    public static function CreateChat($title, $link){
        if (!Chats::find()->where(["link" => $link])->exists()){
            $chat = new Chats();
            $chat->id = ChatClass::GetLastID() + 1;
            $chat->title = $title;
            $chat->link = $link;
            $chat->save();

            ChatClass::AddChat($link, \Yii::$app->user->id);

        }

    }

    public static function AddChat($chatlink, $userID){
        $chat = ChatClass::FindChatByLink($chatlink);
        if (!UserChats::find()->where(["user_id" => $userID, "chat_link" => $chatlink])->exists() && $chat->title != ""){
            $chat = new UserChats();
            $chat->user_id = $userID;
            $chat->chat_link = $chatlink;
            $chat->save();
        }
    }

    public static function RemoveUserFromChat($link){
        if (UserChats::find()->where(["user_id" => \Yii::$app->user->id, "chat_link" => $link])->exists()){
            Yii::$app->db->createCommand('DELETE FROM `user_chats` WHERE `user_id` = '. \Yii::$app->user->id .' AND `chat_link` = "'. $link .'"')->execute();
        }
    }
}