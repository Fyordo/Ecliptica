<?php

/* @var $this yii\web\View */

use app\models\classes\ChatClass;

$this->title = 'Создать чат';
?>
<div class="site-index">

    <div class="row">
        <input name="title" id="title" class="form-control" placeholder="Введите название чата"></input>
        <br>
        <input name="link" id="link" class="form-control" placeholder="Введите ссылку на чат"></input>
        <br>
        <input id="send" type="submit" value="Создать" class="btn btn-primary">
        <br>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    let link = $("#link"); // Ссылка на чат
    let title = $("#title"); // Заголовок
    let chats = $("#chats"); // Чаты

    $(document).on("click", "#send", function() {
        $.ajax({
            type: 'POST',
            url: "http://ecliptica/chat/createchat",
            data: {
                "title": title.val(),
                "link": link.val(),
            },
            dataType: 'text',
            success: function (data) {
                window.location.replace("http://ecliptica/chat/select?link=" + link.val());
            },
            error: function (data) {
                alert("Такой чат создать нельзя!");
            }
        });
    });
</script>
