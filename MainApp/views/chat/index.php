<?php

/* @var $this yii\web\View */
/* @var $id string */
/* @var $chats array[] */
/* @var $model \app\models\Forms\ChatSearchForm */

use app\assets\FindChatAsset;
use app\models\Chat;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Диалоги';
FindChatAsset::register($this);
?>
<div class="site-index">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'link') ?>

    <div class="form-group">
        <?= Html::submitButton('Найти чат', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="userID" data-attr="<?= Yii::$app->user->id ?>"></div>

    <div class="jumbotron">
        <h1>Диалоги получается</h1>
    </div>

    <div class="body-content">

        <div id="chats" class="row">
            <?php
            foreach ($chats as $chat){
                echo Chat::ConstructChat($chat);
            }
            ?>
        </div>

    </div>
</div>