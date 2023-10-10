<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Client Side</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body{
            background-color:#595757;
        }
        li{
            color:#fff
        }
        .chat-section {
            display: flex;
            flex-direction: column;
            height: 95vh; /* Make the chat section occupy the full viewport height */
        }

        .chat-box {
            margin-top: auto; /* Push the input-group to the bottom */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;

        }

        .input-group {
            width: 100%;
            box-shadow: 7px 0px 12px 1px #ffff;
            border-radius: 16px
        }
        .input-group input{
            background-color:transparent;
        }

        .form-control {
            border-radius: 0;
        }

        .send-button {
            border-radius: 0;
        }

        #messages {
            flex: 1; /* Allow the messages to scroll within the chat section */
            overflow-y: auto;
        
        }
        ul {
            list-style-type: none;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5); /* Darker background */
            border-radius: 16px;
            margin: 0;
        }

        /* Add padding to list items */
        ul li {
            padding: 5px;
        }


        button {
  font-family: inherit;
  font-size: 20px;
  background: royalblue;
  color: white;
  padding: 0.7em 1em;
  padding-left: 0.9em;
  display: flex;
  align-items: center;
  border: none;
  border-radius: 16px;
  overflow: hidden;
  transition: all 0.2s;
}

button span {
  display: block;
  margin-left: 0.3em;
  transition: all 0.3s ease-in-out;
}

button svg {
  display: block;
  transform-origin: center center;
  transition: transform 0.3s ease-in-out;
}

button:hover .svg-wrapper {
  animation: fly-1 0.6s ease-in-out infinite alternate;
}

button:hover svg {
  transform: translateX(1.2em) rotate(45deg) scale(1.1);
}

button:hover span {
  transform: translateX(5em);
}

button:active {
  transform: scale(0.95);
}

@keyframes fly-1 {
  from {
    transform: translateY(0.1em);
  }

  to {
    transform: translateY(-0.1em);
  }
}


    </style>
</head>
<body class="antialiased">
    <div class="container">
        <div class="row chat-row" style="margin: 30px">
            <div class="chat-section">
                <ul id="messages"></ul>
                <div class="chat-box mb-3">
                    <div class="input-group">
                        <input type="text" style="border-radius: 16px 0px 0px 16px;" class="form-control" id="chatInput" style="width: auto ;" placeholder="Message">
                        <button  id="sendButton">
                        <div class="svg-wrapper-1">
                            <div class="svg-wrapper">
                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z" fill="currentColor"></path>
                            </svg>
                            </div>
                        </div>
                        <span>Send</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $(function() {
        let ip_address = "127.0.0.1";
        let socket_port = "3000";
        let socket = io(ip_address + ':' + socket_port);

        var messages = document.getElementById('messages');
        let chatInput = $('#chatInput');
        let sendButton = $('#sendButton');

        function sendMessage() {
            let message = chatInput.val();
            if (message.trim() !== "") {
                socket.emit('chat', message);
                chatInput.val("");
            }
        }

        chatInput.keypress(function(e) {
            if (e.which == 13) {
                sendMessage();
            }
        });

        sendButton.click(function() {
            sendMessage();
        });

        socket.on("user-connect", () => {
            const newItem = document.createElement("li");
            newItem.innerText = "----------------------------------------------------------------User Connected.----------------------------------------------------------------";
            newItem.style.color = "green"; // Set the text color to green
            newItem.style.fontWeight = "bold"; // Set the font weight to bold
            messages.appendChild(newItem);
            window.scrollTo(0, document.body.scrollHeight);
        });

        socket.on("user-disconnect", () => {
            const newItem = document.createElement("li");
            newItem.innerText = "---------------------------------------------------------------User Disconnected.---------------------------------------------------------------";
            newItem.style.color = "red"; // Set the text color to green
            newItem.style.fontWeight = "bold"; // Set the font weight to bold
            messages.appendChild(newItem);
            window.scrollTo(0, document.body.scrollHeight);
        });

        socket.on('chat-message', function(msg) {
            var item = document.createElement('li');
            item.textContent = msg;
            messages.appendChild(item);
            window.scrollTo(0, document.body.scrollHeight);
        });
    });
</script>
</html>
