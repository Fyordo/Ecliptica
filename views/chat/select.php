<?php

use app\models\classes\MessageClass;
use app\models\User;
use app\models\classes\ChatClass;

/* @var $this yii\web\View */
/* @var $chat ChatClass */
/* @var $messages array */
/* @var $user User */

$this->title = $chat->title;
$user = Yii::$app->user->identity;
?>
<div class="site-index">

    <div class="jumbotron">
        <?php if ($chat->status != -1): ?>
            <h1><?= $chat->status == 1 ? 'Директ с ' : 'Чат: ' ?> <?= $chat->title ?></h1>
        <?php else: ?>
            <h1>Такого чата нет!</h1>
        <?php endif; ?>
    </div>

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

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/socket.io/client-dist/socket.io.js"></script>
<script>
    $(function() {
        let socket = io('http://localhost:3000');

        let $form = $("#messForm"); // Форму сообщений
        let $textarea = $("#message"); // Текстовое поле
        let $all_messages = $("#all_mess"); // Блок с сообщениями
        let $nomess = $("#nomess"); // Блок с сообщениями

        $form.submit(function(event) {
            event.preventDefault();

            if ($textarea.val() !== ""){

                socket.emit('send mess', {mess: $textarea.val(), name: "<?= $user->username ?>", senderlink: "<?= $user->link ?>", time: "<?= date("H:i d.m.Y") ?>", chat: "<?= $chat->link ?>"});
            }

            $textarea.val('');
        });


        socket.on('add mess', function(data) {
            /*
            data.chat - чат, в который отправляется сообщение
            data.time - время отправки
            data.name - имя отправителя
            data.senderlink - ссылка отправителя
            data.mess - текст сообщения
            */
            if (data.senderlink === "<?= $chat->link ?>"){ // добавление сообщения по ту сторону директа
                $nomess.remove();
                $all_messages.append("<h3 align='left'>" + data.name + " (" + data.time + ")" + "</h3><h4>" + data.mess + "</h3><br>");
                $.ajax({
                    type: 'POST',
                    url: "http://ecliptica/chat/send",
                    data: {
                        "user": data.senderlink,
                        "message": data.mess,
                        "chat": "<?= $chat->link ?>",
                        "time": data.time,
                    },
                    dataType: 'text',
                    success: function(data){

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }

            if (data.chat === "<?= $chat->link ?>"){ // добавление сообщения самому себе и всему чату
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

                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        });
    });
</script>