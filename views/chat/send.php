<?php

use app\models\classes\MessageClass;
use app\models\User;

if ($_POST["user"] != null){
    MessageClass::AddMessage($_POST["chat"], $_POST["message"], $_POST["time"], User::findByLink($_POST["user"]));
}
else{
    MessageClass::AddMessage($_POST["chat"], $_POST["message"], $_POST["time"]);
}

