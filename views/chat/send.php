<?php

use app\models\classes\MessageClass;
use app\models\User;
/*
if ($_POST["isDirect"] == "true"){
    MessageClass::AddMessage(Yii::$app->user->identity->link, $_POST["message"], $_POST["time"]);
}
*/
if ($_POST["user"] != null){
    MessageClass::AddMessage($_POST["chat"], $_POST["message"], $_POST["time"], User::findByLink($_POST["user"]));
}
else{
    MessageClass::AddMessage($_POST["chat"], $_POST["message"], $_POST["time"]);
}

