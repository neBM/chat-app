const WebSocket = require("ws");
const  wss = new WebSocket.Server({port: 80});

wss.on('connection', function connection(ws, req) {
	console.log(wss.clients.size);
	ws.on('message', function incoming(message) {
		console.log('received: %s', message);
		wss.clients.forEach(function (client) {
			if (client == ws) {
				return;
			}
			client.send(message);
		})
	});


        wss.clients.forEach(function (client) {
                client.send("A new user has joined");
        })
});
