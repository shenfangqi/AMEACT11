var io = require('socket.io').listen(3000);

chat = io.sockets.on('connection', function(client) {
    client.emit('connected');

    client.on('init', function(req) {
        client.set('room', req.room);
        client.set('name', req.name);

        console.log(req.room +":"+ req.name);

//        chat.to(req.room).emit('message', req.name + " is coming.");
        client.join(req.room);
        client.broadcast.to(req.room).emit("other",req.name + " is coming.");
    });

    client.on('message', function(da) {
        var room, name, data;

        client.get('room', function(err, _room) {
            room = _room;
        });
        client.get('name', function(err, _name) {
            name = _name;
        });
        
//        room = da.room;
//        name = da.name;
//        data = da.info;

        console.log(room +":"+ name +" "+ da);

//        chat.to(room).emit('other', "info:" + da);
        client.broadcast.to(room).emit("other",da);

    });

    client.on('disconnect', function() {
        var room, name;

        client.get('room', function(err, _room) {
            room = _room;
        });
        client.get('name', function(err, _name) {
            name = _name;
        });
        client.leave(room);
//        chat.to(room).emit('message', name + "is going");

        client.broadcast.to(room).emit("other",name + "is going");

    });
});
