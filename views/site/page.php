<?php

/* @var $this yii\web\View */
/* @var $page_owner string[] */
/* @var $user \app\models\User */

use yii\helpers\Html;

$user = Yii::$app->session["user"];
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

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
