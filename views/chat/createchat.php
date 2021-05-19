<?php

use app\models\classes\ChatClass;

if ($_POST["title"] != "" && $_POST["link"] != ""){
    ChatClass::CreateChat($_POST["title"], $_POST["link"]);
}
