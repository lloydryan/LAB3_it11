const express = require("express");
const app = express();
const http = require("http");

// Express initializes app to be a function handler that you can supply to an HTTP server
const server = http.createServer(app);

// Socket IO dependency with CORS
const io = require("socket.io")(server, {
  cors: { origin: "*" },
});

// Route handler that gets called when we hit our website home.
app.get("/", (req, res) => {
  res.sendFile(__dirname + "/client/index.html");
});

io.on("connection", (socket) => {
  socket.broadcast.emit("user-connect");

  socket.on("chat", (msg) => {
    io.emit("chat-message", msg);
  });

  socket.on("disconnect", () => {
    io.emit("user-disconnect");
  });
});

// http server listen on port 3000
server.listen(3000, () => {
  console.log("listening on *:3000");
});
