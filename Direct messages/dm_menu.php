<!DOCTYPE html>

<html> 
    
    <head>
        <meta charset="utf-8">
        <title> Mes DM </title>
    </head>
    <body>
        <h1> Mes DM </h1>
        <div className="mes_conversations">
          <h2>Mes conversations</h2>
            <ul>
                <?php foreach ($conv_id as $contact) : // affichage des conversations ?> 
                    <li>
                        <?= $contact['conv_id'] ?>
                    </li>
            </ul>
        </div>
        
    </body>
</html>

<?php

if(!isset($_GET['id'])) // vérifie si id est dans l'url
{
    header('location:menu.php');
}
else {
    $user_id = $_GET['id'];
}

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

// Récupération des conversations de l'utilisateur
$conv_id = pg_query($connect, "SELECT conv_id FROM conversations WHERE user_id = $user_id");

?>
