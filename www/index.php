<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/master.css">
        <link rel="stylesheet" href="/styles/index.css">
        <title>Chat</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            class UIMessage {
                constructor (message, is_sender) {
                    this.message = message;
                    this.is_sender = is_sender;
                    
                    this.show();
                }
                
                show() {
                    
                    let messageElement = $($("#messageTemplate").html());
                    if (this.is_sender) {
                        messageElement.addClass("sender")
                        ws.send(this.message);
                    }
                    messageElement.find(".content").text(this.message);
                    this.messageElement = $("#chatlog ul").append(messageElement)
                    chatlog[0].scrollTop = chatlog[0].scrollHeight;
                }
            }
            var ws;
            var messages = [];
            var chatlog;
            $(function () {
                ws = new WebSocket("wss://chat.martinilink.co.uk/ws");
                chatlog = $("#chatlog")
                ws.onopen = function (e) {

                }
                ws.onmessage = function (e) {
                    console.log(e);
                    messages.push(new UIMessage(e.data, false))
                }

                $("#messageArea").on("keypress", function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        $("#sendButton").click();
                    }
                })

                $("#sendButton").click(function (e) {
                    let message = $("#messageArea").val().trim();
                    if (message == "") {
                        return;
                    }

                    $("#messageArea").val("");

                    messages.push(new UIMessage(message, true))
                })
            })

        </script>
    </head>
    <body>
        <div class="main" id="layoutContaienr">
            <div id="contactsContainer">
                <!-- Contacts -->
                <ul id="contactsList">
                    <li>Ben Maritn</li>
                    <li>Hitler</li>
                </ul>
            </div>
            <template id="messageTemplate">
                <li class="message">
                    <div class="content"></div>
                </li>
            </template>
            <div id="chatlogContainer">
                <div>
                    <p>Ben Martin</p>
                </div>
                <!-- Chat log -->
                <div id="chatlog">
                    <ul>

                    </ul>
                </div>
                <div id="actionsContainer">
                    <textarea name="" id="messageArea"></textarea>
                    <button type="button" id="sendButton">SEND</button>
                </div>
            </div>
        </div>
    </body>
</html>