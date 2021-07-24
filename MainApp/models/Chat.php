<?php


namespace app\models;


use app\models\DbModels\ChatBinds;
use app\models\DbModels\Chats;
use Yii;

class Chat
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
}