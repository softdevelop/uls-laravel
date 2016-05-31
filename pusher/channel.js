var channel = {};

channel.startChannel = function(socket, redisClient, channelName){
	redisClient.subscribe(channelName, function(channel, message){
		socket.emit(channel, message);
	});
}

channel.stopChannel = function(socket, redisClient, channelName){
	redisClient.unsubscribe(channelName, function(channel, message){
		socket.emit(channel, message);
	});
}

module.exports = channel;