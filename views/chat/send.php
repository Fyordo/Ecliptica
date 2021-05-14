<?php

use app\models\classes\MessageClass;

if ($_POST["isDirect"] == "true"){
    MessageClass::AddMessage($_POST["chat"], $_POST["message"], $_POST["time"]);
    MessageClass::AddMessage(Yii::$app->user->identity->link, $_POST["message"], $_POST["time"]);
}
else{
    MessageClass::AddMessage($_POST["chat"], $_POST["message"], $_POST["time"]);
}
