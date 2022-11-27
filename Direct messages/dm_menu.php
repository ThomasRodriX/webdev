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
                <?php foreach ($conv_id as $contact) : ?>
                    <li>
                        <?= $contact['conv_id'] ?>
                    </li>
            </ul>
        </div>
        
    </body>
</html>

<?php
$objetPdo = new PDO('mysql:host=localhost;dbname=twitter','root','root'); // a personnaliser



curent_user = $_GET['user'] // id du user courant

//recupération des conversations id
$pdoStat = $objetPdo->prepare("SELECT 'id' FROM `conversations` WHERE 'user_0'='curent_user' OR 'user_1'='curent_user';
VALUES ('$conv_id')");


$executeIsOk = $pdoStat->execute();

//recupération des résultats
$conv_id = $pdoStat->fetchAll();

?>
