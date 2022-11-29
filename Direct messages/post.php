<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
     
    $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
    // connect to postgresql
    $user = "grp47oxh6hjegww"; 
    $password = "99yXmThpFno";
    $host = "esilv.olfsoftware.fr";
    $port = "5432";
    $dbname = "pggrp4";
    
    $connect = pg_connect("host=$host port=5432 dbname=$dbname user=$user password=$password");
    $query = "INSERT INTO webdev.messages VALUES ('135', '$convId', '$id', '$text', null, null)";
    $newMessages = pg_query($connect, $query);


    file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX); //remplce db pour le moment
}
?>