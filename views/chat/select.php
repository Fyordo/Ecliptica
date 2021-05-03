<?php

/* @var $this yii\web\View */
/* @var $chat app\models\classes\ChatClass */

$this->title = 'Chat Application';
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



    </div>
</div>
