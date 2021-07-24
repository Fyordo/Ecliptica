let userlink = $("#userLink"); // Ссылка на пользователя
let chatLink = document.querySelector('.chatLink').getAttribute('data-attr'); // Ссылка на чат

$(document).on("click", "#set", function() {
    $.ajax({
        type: 'POST',
        url: "http://localhost:8000/chat/addadmin",
        data: {
            "userLink": userlink.val(),
            "chatLink": chatLink
        },
        dataType: 'text',
        success: function (data) {
            alert("Пользователю даны права админа");
        },
        error: function (data) {
            console.log("Ошибка");
        }
    });
});