var net = require("net");
var dataClient = new net.Socket();

var port = 7331;
var io = require('socket.io')(7331);

function connect(dataClient) {
  dataClient.connect(1337, '127.0.0.1', function () {
    console.log('connected to data server');
  });
}

connect(dataClient);

dataClient.on('data', function (data) {
  console.log('data receieved from data server');
  console.log(data.toString());
  io.emit('data', data.toString());
});

dataClient.on('close', function () {
  console.log('disconnected from data server');
});


io.on('connection', function (socket) {
  console.log('web client has connected to this server');
});
