<?php

/* @var $this yii\web\View */
/* @var $id string */
/* @var $chats array[] */

use app\models\Chat;
/*
Yii::$app->session->set('user', [
                'id' => 2,
                'username' => 'TestUser',
                'link' => '@test',
                'password' => 'test',
                'status' => 0
            ]);
*/
$this->title = 'Chats';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Чаты получается</h1>
    </div>

    <div class="body-content">

        <div class="row">
                <?php
                    foreach ($chats as $chat){
                        echo Chat::ConstructChat($chat);
                    }
                ?>
        </div>

    </div>
</div>
