<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>chatapp</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

    
</head>
<body>
    <div id="wrapper">  
        <div id="user-container">   
            <label for="user">What's your name?</label>
            <input type="text" id="user" name="user">
            <button type="button" id="join-chat">Join Chat</button>
        </div>

        <div id="main-container" class="hidden">        
            <button type="button" id="leave-room">Leave</button>
            <div id="messages">

            </div>

            <div id="msg-container">
                <input type="text" id="msg" name="msg">
                <button type="button" id="send-msg">Send</button>
            </div>
        </div>

    </div>

    <script id="messages-template" type="text/x-handlebars-template">
        {{#each messages}}
        <div class="msg">
            <div class="time">{{time}}</div>
            <div class="details">
                <span class="user">{{user}}</span>: <span class="text">{{text}}</span>
            </div>
        </div>
        {{/each}}
    </script>

    <script>
    	(function(){

    var user;
    var messages = [];

    var messages_template = Handlebars.compile($('#messages-template').html());

    function updateMessages(msg){
        messages.push(msg);
        var messages_html = messages_template({'messages': messages});
        $('#messages').html(messages_html);
        $("#messages").animate({ scrollTop: $('#messages')[0].scrollHeight}, 1000);
    }

    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        var msg = JSON.parse(e.data);
        updateMessages(msg);
    };


    $('#join-chat').click(function(){
        user = $('#user').val();
        $('#user-container').addClass('hidden');
        $('#main-container').removeClass('hidden');

        var msg = {
            'user': user,
            'text': user + ' entered the room',
            'time': moment().format('hh:mm a')
        };

        updateMessages(msg);
        conn.send(JSON.stringify(msg));

        $('#user').val('');
    });


    $('#send-msg').click(function(){
        var text = $('#msg').val();
        var msg = {
            'user': user,
            'text': text,
            'time': moment().format('hh:mm a')
        };
        updateMessages(msg);
        conn.send(JSON.stringify(msg));

        $('#msg').val('');
    });


    $('#leave-room').click(function(){

        var msg = {
            'user': user,
            'text': user + ' has left the room',
            'time': moment().format('hh:mm a')
        };
        updateMessages(msg);
        conn.send(JSON.stringify(msg));

        $('#messages').html('');
        messages = [];

        $('#main-container').addClass('hidden');
        $('#user-container').removeClass('hidden');

        conn.close();
    });

})();
    </script>
</body>
</html>