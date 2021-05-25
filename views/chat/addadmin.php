<?php

use app\models\classes\ChatClass;
use app\models\User;


ChatClass::SetToAdmin($_POST["chatLink"], User::findByLink($_POST["userID"])->id);