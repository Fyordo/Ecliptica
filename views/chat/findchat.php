<?php

use app\models\classes\ChatClass;
use app\models\User;

if ($_POST["chat"] != ""){
    if (ChatClass::FindChatByLink($_POST["chat"]) !== null){
        ChatClass::AddChat($_POST["chat"], $_POST["user"], 0);
    }
}
