<?php

/* @var $this yii\web\View */
/* @var $page_owner string[] */
/* @var $user \app\models\User */

use yii\helpers\Html;

$user = Yii::$app->user->identity;
$this->title = $user->username;

?>
<div class="site-index">

    <div class="jumbotron">
        <?php
            if ($page_owner == null) echo '<h1>Такого пользователя нет!</h1>';
            else{
                echo '
                <h1>Пользователь:' . $page_owner["username"] . '</h1>

                <p class="lead">ID = ' . $page_owner["id"] . '</p>
                ';

                if ($page_owner["id"] != $user->id){
                    echo "<p class='lead'>И это не твоя страница!</p>";
                }
                else{
                    echo "<p class='lead'>И это твоя страница!</p>";
                    echo Html::beginForm(['/logout'], 'post') .
                        Html::submitButton('Logout', ['class' => 'btn btn-link logout']) . Html::endForm();
                }
            }
        ?>

        <?php

        ?>

    </div>
</div>
