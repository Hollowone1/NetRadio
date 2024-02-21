const express = require("express");
const http = require("http");
// const socketIO = require("socket.io");
const path = require("path");

const app = express();
// const server = http.createServer(app);
// const io = socketIO(server);

const server = http.createServer(app);
const { Server } = require("socket.io");
const options = {
    cors: {
        origin: ['http://localhost:5173']
    },
    // wssAdapter: MyWSSAdapter
}
const io = new Server(server, options);

const port = 3000;

const public2 = path.join("/web/NetRadio/public");
app.use(express.static(public2));

app.set('view engine', 'hbs');

app.get('/', (req, res) => {
    res.render("index");
});

const onlineUsers = {};

// Socket.IO logic
io.on('connection', (socket) => {
    socket.on("joinedusername", (username) => {
        onlineUsers[socket.id] = username;

        io.emit("allonlineusers", Object.values(onlineUsers));
    });

    socket.on("audio", (data) => {
        socket.broadcast.emit("audio1", data);
    });

    socket.on('disconnect', () => {
        const username = onlineUsers[socket.id];

        if (username) {
            delete onlineUsers[socket.id];

            io.emit("allonlineusers", Object.values(onlineUsers));
        }
    });
});

server.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});