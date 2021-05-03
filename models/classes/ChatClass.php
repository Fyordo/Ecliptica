<?php

namespace app\models\classes;

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
}