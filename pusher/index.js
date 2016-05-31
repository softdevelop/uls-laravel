var app = require('http').createServer(handler);
var io = require('socket.io')(app);

var Redis = require('ioredis');
var redis = new Redis();
// var redis = new Redis({
//   port: 8889,          // Redis port
//   host: '127.0.0.1',   // Redis host
//   family: 4,           // 4(IPv4) or 6(IPv6)
//   password: 'auth',
//   db: 0
// });

app.listen(8891, function() {
    console.log('Server is running!');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('hello');
}

io.on('connection', function(socket) {
	io.on('connection', function(socket){
		console.log('good');
	   // io.emit('message', 'hello');
	});
     
});

redis.psubscribe('*', function(err, count) {
    //
    //
    console.log(count,err,'sdfsdf');
});

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);
    console.log(channel + ':' + message.event);
    // io.emit('message', message.data);
    io.emit(channel + ':' + message.event, message.data);
});
