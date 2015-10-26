var express = require('express');
var bodyParser = require('body-parser');
var app = express();
app.use(bodyParser.urlencoded({
  extended: true
}));

app.use(bodyParser.json());

var router = express.Router();

var wsPort = 1337;
var io = require('socket.io')(wsPort);
router.post('/', function (req, res) {
  res.json(req.body);
  io.emit('data', req.body);
});

app.use('/sb', router);

var httpPort = 7331;
app.listen(httpPort);
