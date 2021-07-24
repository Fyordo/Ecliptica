<?php

use app\models\Chat;
use app\models\Message;
use app\models\User;
use app\assets\ChatAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $chat Chat */
/* @var $messages array */
/* @var $user User */
/* @var $isadmin bool */
/* @var $modelAdmin \app\models\Forms\AddAdminForm */

$this->title = $chat->title == null ? "Чат не найден" : $chat->title;
$user = Yii::$app->user->identity;



ChatAsset::register($this);
?>
<div class="site-index">
    <?php if ($isadmin): ?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($modelAdmin, 'userLink') ?>

        <div class="form-group">
            <?= Html::submitButton('Дать права администратора', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php endif; ?>

    <div class="jumbotron">
        <?php if ($chat->title != ""): ?>
            <h1><?= 'Чат: ' ?> <?= $chat->title ?></h1>
            <a href="exitchat?link=<?= $chat->link ?>">Выйти</a>
        <?php else: ?>
            <h1>Такого чата нет!</h1>
        <?php endif; ?>
    </div>
    <?php if ($chat->title != ""): ?>

        <div id="all_mess" class="body-content">
            <?= Message::ConstructMessagesBox($messages); ?>
        </div>

        <div class="chatLink" data-attr="<?= $chat->link ?>"></div>
        <div class="username" data-attr="<?= $user->username ?>"></div>

        <?php if ($isadmin): ?>


            <form id="messForm">
                <textarea name="message" id="message" class="form-control" placeholder="Введите сообщение"></textarea>
                <br>
                <input id="send" type="submit" value="Отправить" class="btn btn-primary">
                <br>
                <br>
                <br>
                <br>
                <br>
            </form>
        <?php endif; ?>
    <?php endif; ?>

</div>