$(function() {
    let socket = io('http://localhost:3000');

    let $form = $("#messForm"); // Форму сообщений
    let $textarea = $("#message"); // Текстовое поле
    let $all_messages = $("#all_mess"); // Блок с сообщениями
    let $nomess = $("#nomess"); // Надпись "сообщений нет"

    let chatLink = document.querySelector('.chatLink').getAttribute('data-attr'); // Ссылка на чат
    let username = document.querySelector('.username').getAttribute('data-attr'); // Ник пользователя

    $form.submit(function(event) {
        event.preventDefault();

        if ($textarea.val() !== ""){

            socket.emit('send mess', {mess: $textarea.val(), name: username, chat: chatLink});
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
        if (data.chat === chatLink){
            $nomess.remove();
            $all_messages.append("<h3 align='left'>" + data.name + " (" + data.time + ")" + "</h3><h4>" + data.mess + "</h3><br>");
            if (data.name === username){
                $.ajax({
                    type: 'POST',
                    url: "http://localhost:8000/chat/send",
                    data: {
                        "user": null,
                        "message": data.mess,
                        "chat": chatLink,
                        "time": data.time
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
        }
    });
});