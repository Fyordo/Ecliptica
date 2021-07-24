let textarea = $("#link"); // Текстовое поле
let chats = $("#chats"); // Чаты
let userId = document.querySelector('.userID').getAttribute('data-attr'); // ID пользователя

$(document).on("click", "#find", function() {
    $.ajax({
        type: 'POST',
        url: "http://localhost:8000/chat/findchat",
        data: {
            "user": userId,
            "chat": textarea.val()
        },
        dataType: 'text',
        success: function (data) {
            window.location.replace("http://localhost:8000/chat/select?link=" + textarea.val());
        },
        error: function (data) {
            console.log("Ошибка\n" + userId.val());
        }
    });
});