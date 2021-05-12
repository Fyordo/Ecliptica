<?php

use app\models\classes\MessageClass;

/* @var $this yii\web\View */
/* @var $chat app\models\classes\ChatClass */
/* @var $messages array */

$this->title = $chat->title;
?>
<div class="site-index">

    <div class="jumbotron">
        <?php if ($chat->status != -1): ?>
            <h1><?= $chat->status == 1 ? 'Директ с ' : 'Чат: ' ?> <?= $chat->title ?></h1>
        <?php else: ?>
            <h1>Такого чата нет!</h1>
        <?php endif; ?>
    </div>

    <div class="body-content">

        <?= MessageClass::ConstructMessagesBox($messages); ?>

    </div>

</div>