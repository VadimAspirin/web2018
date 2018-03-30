<div class="display-default-index">
    <h1>Дисплей</h1>
</div>

<div id="display"></div>
<style>
</style>
<script>
    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        var msg = JSON.parse(e.data);
        var html = '<table class="table table-striped">';
        html+='<tr><th>Номерок</th><th>Окно</th></tr>';
        for (var i=0;i<msg.length;i++) {
            html+='<tr><td>'+msg[i]['ticketName']+'</td>';
            html+='<td>'+msg[i]['workspace']+'</td></tr>';
            }
        html+='</table>';
        document.getElementById('display').innerHTML=html;

        //document.getElementById("display").innerHTML=msg[1]['ticketName'];
        //document.getElementById("display1").innerHTML=msg[1]['workspace'];
        
        //document.getElementById("test").innerHTML='message： ' + e.data;
    };
</script>