<?php

/* @var $this yii\web\View */
/* @var $model \app\models\Forms\ChatCreationForm */

use app\assets\CreateAsset;
use app\models\Chat;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Создать чат';
CreateAsset::register($this);
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'title') ?>

<?= $form->field($model, 'link') ?>

<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
