var io = require('socket.io').listen(3000);

io.sockets.on('connection', function (socket) {
  socket.on('set nickname', function (name) {
    socket.set('nickname', name, function () {
      //socket.emit('ready');
    });
  });

  socket.on('msg', function (data) {
       console.log("msg:"+data);
       socket.broadcast.emit("other",data);    
  });

  socket.on('chat', function (data) {
       console.log("chat:"+data);
       var nick;
       socket.get('nickname', function (err, name) {
          //console.log('Chat message by ', name);
          nick = name;
       });

       //console.log('Chat message by ', nick);
       socket.broadcast.emit("other","SA"+nick+":"+data);
  });


  socket.on('act', function (data) {
       console.log("act:"+data);
       var nick;
       socket.get('nickname', function (err, name) {
          //console.log('Chat message by ', name);
          nick = name;
       });

       //console.log('ACT message by ', nick);
       socket.broadcast.emit("other","AC"+nick+":"+data);
  });


  socket.on('cloth', function (data) {
       console.log("cloth:"+data);

       socket.get('nickname', function (err, name) {
          //console.log('Chat message by ', name);
          nick = name;
       });

       socket.broadcast.emit("other","CL"+nick+":"+data);
  });


  socket.on('disconnect', function () {
       var nick;
       socket.get('nickname', function (err, name) {
          //console.log('Chat message by ', name);
          nick = name;
       });

       console.log(nick+" disconnected");
       socket.broadcast.emit("other","LO"+nick);
  });
});
