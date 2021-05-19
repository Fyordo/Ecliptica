<?php

use app\models\classes\MessageClass;
use app\models\User;
use app\models\classes\ChatClass;

/* @var $this yii\web\View */
/* @var $chat ChatClass */
/* @var $messages array */
/* @var $user User */

$this->title = $chat->title == null ? "Чат не найден" : $chat->title;
$user = Yii::$app->user->identity;

?>
<div class="site-index">

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

            <?= MessageClass::ConstructMessagesBox($messages); ?>

        </div>

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

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/socket.io/client-dist/socket.io.js"></script>
<script>
    $(function() {
        let socket = io('http://localhost:3000');

        let $form = $("#messForm"); // Форму сообщений
        let $textarea = $("#message"); // Текстовое поле
        let $all_messages = $("#all_mess"); // Блок с сообщениями
        let $nomess = $("#nomess"); // Надпись "сообщений нет"

        $form.submit(function(event) {
            event.preventDefault();

            if ($textarea.val() !== ""){

                socket.emit('send mess', {mess: $textarea.val(), name: "<?= $user->username ?>", chat: "<?= $chat->link ?>"});
            }

            $textarea.val('');
        });


        socket.on('add mess', function(data) {

            /*
            data.chat - чат, в который отправляется сообщение
            data.time - время отправки
            data.name - имя отправителя
            data.mess - текст сообщения
            */

            // добавление сообщения самому себе и всему чату
            if (data.chat === "<?= $chat->link ?>"){
                $nomess.remove();
                $all_messages.append("<h3 align='left'>" + data.name + " (" + data.time + ")" + "</h3><h4>" + data.mess + "</h3><br>");
                $.ajax({
                    type: 'POST',
                    url: "http://ecliptica/chat/send",
                    data: {
                        "user": null,
                        "message": data.mess,
                        "chat": "<?= $chat->link ?>",
                        "time": data.time,
                    },
                    dataType: 'text',
                    success: function(data){
                        console.log("Отправлено");
                    },
                    error: function(data){
                        console.log("Ошибка");
                    }
                });
            }
        });
    });
</script>