<?php

/* @var $this yii\web\View */
/* @var $id string */
/* @var $chats array[] */

use app\models\classes\ChatClass;

$this->title = 'Диалоги';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Диалоги получается</h1>
    </div>

    <div class="body-content">

        <div class="row">
                <?php
                    foreach ($chats as $chat){
                        echo ChatClass::ConstructChat($chat);
                    }
                ?>
        </div>

    </div>
</div>
