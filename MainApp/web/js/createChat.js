let link = $("#link"); // Ссылка на чат
let title = $("#title"); // Заголовок
let chats = $("#chats"); // Чаты

$(document).on("click", "#send", function() {
    $.ajax({
        type: 'POST',
        url: "http://localhost:8000/chat/createchat",
        data: {
            "title": title.val(),
            "link": link.val(),
        },
        dataType: 'text',
        success: function (data) {
            window.location.replace("http://localhost:8000/chat/select?link=" + link.val());
        },
        error: function (data) {
            alert("Такой чат создать нельзя!");
        }
    });
});