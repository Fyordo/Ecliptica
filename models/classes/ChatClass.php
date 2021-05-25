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
     * Найти чат по ссылке
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
     * Найти все чаты из списка пользователя
     *
     * @param $UserID
     * @return array
     */
    public static function GetChatsList($UserID) : array{
        $chatsList = UserChats::find()->where(['user_id' => $UserID])->all();
        $chats = [];

        foreach ($chatsList as $CurrChat){
            $chat = ChatClass::FindChatByLink($CurrChat->attributes["chat_link"]);

            array_push($chats, $chat);
        }
        return $chats;
    }

    /**
     * Создать ячейку с чатом
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

    /**
     * Получить последний ID чатов из существующих
     *
     * @return mixed
     */
    private static function GetLastID(){
        $lastChat = Chats::find()->orderBy(['id' => SORT_DESC])->one();
        return $lastChat->attributes["id"];
    }

    /**
     * Создаёт чат, проверив ссылку
     *
     * @param $title
     * @param $link
     */
    public static function CreateChat($title, $link){
        if (!Chats::find()->where(["link" => $link])->exists()){
            $chat = new Chats();
            $chat->id = ChatClass::GetLastID() + 1;
            $chat->title = $title;
            $chat->link = $link;
            $chat->save();

            ChatClass::AddChat($link, \Yii::$app->user->id, 1);

        }

    }

    /**
     * Добавляет чат в списки к пользователю
     *
     * @param $chatlink
     * @param $userID
     * @param $isadmin
     */
    public static function AddChat($chatlink, $userID, $isadmin){
        $chat = ChatClass::FindChatByLink($chatlink);
        if (!UserChats::find()->where(["user_id" => $userID, "chat_link" => $chatlink])->exists() && $chat->title != ""){
            $chat = new UserChats();
            $chat->user_id = $userID;
            $chat->chat_link = $chatlink;
            $chat->isadmin = $isadmin;
            $chat->save();
        }
    }

    /**
     * Дать пользователю права админу в чате
     *
     * @param $chatLink
     * @param $userID
     */
    public static function SetToAdmin($chatLink, $userID){
        self::RemoveUserFromChat($chatLink, $userID);
        $chat = new UserChats();
        $chat->user_id = $userID;
        $chat->chat_link = $chatLink;
        $chat->isadmin = 1;
        $chat->save();
    }

    /**
     * Убрать чат из списка пользователя + забрать все права
     *
     * @param $link
     * @param null $userID
     * @throws \yii\db\Exception
     */
    public static function RemoveUserFromChat($link, $userID = null){
        if ($userID == null) $userID = Yii::$app->user->id;
        if (UserChats::find()->where(["user_id" => \Yii::$app->user->id, "chat_link" => $link])->exists()){
            Yii::$app->db->createCommand('DELETE FROM `user_chats` WHERE `user_id` = '. $userID .' AND `chat_link` = "'. $link .'"')->execute();
        }
    }

    /**
     * Является ли пользователь админом?
     *
     * @param $userID
     * @param $chatLink
     * @return mixed
     */
    public static function IsAdmin($userID, $chatLink){
        $chatInfo = UserChats::find()->where([
            'user_id' => $userID,
            'chat_link' => $chatLink
        ])->one();
        return $chatInfo->attributes["isadmin"];
    }

}