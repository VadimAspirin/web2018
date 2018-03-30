<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<div id="test">
	</div>
	<?php //echo '1'; ?>
    <script>
	    

	    var conn = new WebSocket('ws://localhost:8080');
	    conn.onopen = function(e) {
	        console.log("Connection established!");
	    };

	    conn.onmessage = function(e) {
	        var msg = JSON.parse(e.data);
	        document.getElementById("test").innerHTML='message： ' + e.data;
	    };

	</script>
    <?php //echo '2'; ?>
</head>
</html>
