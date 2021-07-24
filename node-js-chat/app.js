const express = require("express")
const app = express()
const cors = require('cors')

app.use(cors())

const server = require("http").createServer(app)
const io = require("socket.io")(server)

const port = 3000;
server.listen(port, 'localhost', function() {
    console.log('Listening to port: ' + port);
})

app.use(function (req, res, next) {
    let origins = [
        'http://localhost:8000/'
    ];

    for(let i = 0; i < origins.length; i++){
        let origin = origins[i];

        if(req.headers.origin.indexOf(origin) > -1){
            res.header('Access-Control-Allow-Origin', req.headers.origin);
        }
    }

    res.header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
});

// Настройки сокета

connections = [];

io.on('connection', function(socket) {
    console.log("Успешное соединение");
    connections.push(socket);

    socket.on('disconnect', function(data) {
        connections.splice(connections.indexOf(socket), 1);
        console.log("Отключились");
    });

    socket.on('send mess', function(data) {
        if (data.name !== ""){
            console.log("(" + getDateTime() + ") отправлено сообщение в чат " + data.chat + " (" + data.name + ")");
            io.emit('add mess', {mess: data.mess, name: data.name, time: getDateTime(), chat: data.chat});
        }
        else{

        }
    });
});

// Дичь всякая

function getDateTime() {

    var date = new Date();

    var hour = date.getHours();
    hour = (hour < 10 ? "0" : "") + hour;

    var min  = date.getMinutes();
    min = (min < 10 ? "0" : "") + min;

    var sec  = date.getSeconds();
    sec = (sec < 10 ? "0" : "") + sec;

    var year = date.getFullYear();

    var month = date.getMonth() + 1;
    month = (month < 10 ? "0" : "") + month;

    var day  = date.getDate();
    day = (day < 10 ? "0" : "") + day;

    return hour + ":" + min + " " + day + "." + month + "." + year;

}