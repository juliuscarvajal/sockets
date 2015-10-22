var port = 7331;
var io = require('socket.io')(7331);

io.on('connection', function (socket) {
  console.log('web client has connected to this server');
  socket.on('broadcast', function(msg) {
    console.log('data receieved');
    console.log(msg);
    io.emit('data', msg);  
  });
});

