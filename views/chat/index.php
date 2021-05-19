<?php

/* @var $this yii\web\View */
/* @var $id string */
/* @var $chats array[] */

use app\models\classes\ChatClass;

$this->title = 'Диалоги';
?>
<div class="site-index">

    <div class="row">
        <input name="link" id="link" class="form-control" placeholder="Введите ссылку на чат"></input>
        <br>
        <input id="find" type="submit" value="Поиск" class="btn btn-primary">
        <br>
    </div>

    <div class="jumbotron">
        <h1>Диалоги получается</h1>
    </div>

    <div class="body-content">

        <div id="chats" class="row">
                <?php
                    foreach ($chats as $chat){
                        echo ChatClass::ConstructChat($chat);
                    }
                ?>
        </div>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    let textarea = $("#link"); // Текстовое поле
    let chats = $("#chats"); // Чаты

    $(document).on("click", "#find", function() {
        $.ajax({
            type: 'POST',
            url: "http://ecliptica/chat/findchat",
            data: {
                "user": "<?= Yii::$app->user->id ?>",
                "chat": textarea.val(),
            },
            dataType: 'text',
            success: function (data) {
                window.location.replace("http://ecliptica/chat/select?link=" + textarea.val());
            },
            error: function (data) {
                console.log("Ошибка");
            }
        });
    });
</script>
