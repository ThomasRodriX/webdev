<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
     
    $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";

    //$newMessages = pg_query($connect, 'INSERT INTO messages VALUES (' $convId', '$id', '$text', '', 'NOW()')');


    file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX); //remplce db pour le moment
}
?>