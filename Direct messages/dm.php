<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes DM</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="title">Mes DM</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Dites ce qui vous passe par la tête ! </p>
                </div>
            </div>
        </div>
        <div class="typing-field">
			<form>
            <div class="input-data">
                <input id="data" type="text" name = "newMessage" placeholder="Ecrivez quelque chose .." required>
                <button type = "submit" id="send-btn">Envoyer</button>
            </div>
			</form>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                
                // ajax code
                $.ajax({
                    url: 'message.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>
    
</body>
</html>

<?php

// check if user id is in url
if(isset($_GET['id']))
{
	// get user id
	$user_id = $_GET['id'];
}
else
{
	header('location:menu.php');
}

// check if convId is in url
if(isset($_GET['convId']))
{
	// get convId
	$convId = $_GET['convId'];
}
else
{
	header('location:menu.php');
}

//SQL

// connect to postgresql
$user = "grp47oxh6hjegww"; 
$password = "99yXmThpFno";
$host = "https://pga.esilv.olfsoftware.fr/";
$port = "5432";
$dbname = "pggrp4";
//$myPDO = new PDO("pgsql:host=$host;dbname=$dbname', $user, $password");
$connect = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if(!$connect){
	echo "Unable to connect to the database.";
} 
else{
	
	$result = pg_query($connect, "SELECT sender_id,text  FROM messages WHERE convo_id = $convId");

	while ($row = pg_fetch_row($result)) {
		echo "Sender ID: $row[0]  Message: $row[1]";
		echo "<br />\n";
}

}

// Add new message to the database

// get message
$message = $_POST['newMessage'];
$user_file = fopen('user_file.txt', 'a+');
fputs($user_file, "======================================== \n");
fputs($user_file, $message . "\n");
	
// insert message into database
$sql = "INSERT INTO messages (sender_id, convo_id, text) VALUES ('$user_id', '$convId', '$message')";
$result = pg_query($connect, $sql);
	



?>
