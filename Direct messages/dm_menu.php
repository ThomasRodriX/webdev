<!DOCTYPE html >

<html lang="fr"> 
    
    <head>
        <meta charset="utf-8">
        <title> Mes DM </title>
    </head>
    <body>
        <h1> Mes DM </h1>
        <div className="mes_conversations">
          <h2>Mes conversations</h2>
            <ul>
                <?php
                    if(!isset($_GET['id'])) // vérifie si id est dans l'url du client est dans l'url
                    {
                        header('location:menu.php');
                    }
                    // connect to postgresql
                    $user = "grp47oxh6hjegww"; 
                    $password = "99yXmThpFno";
                    $host = "esilv.olfsoftware.fr";
                    $port = "5432";
                    $dbname = "pggrp4";

                    $connect = pg_connect("host=$host port=5432 dbname=$dbname user=$user password=$password");

                    if(!$connect){
                        echo "Unable to connect to the database.";
                    } 
                    $user_id = $_GET['id'];

                    // Récupération des conversations de l'utilisateur
                    $query = "SELECT id,user_0,user_1 FROM webdev.conversations WHERE user_0 = '".$user_id."' OR user_1 = '".$user_id."'";
                    $conv = pg_query($connect, $query);

                    // affichage des conversations

                        //afficher les conversations
                        

                        //var_dump($conv);

                        
                        while ($row = pg_fetch_row($conv)) {

                            // Récupérer le nom de l'autre utilisateur
                            if($row[1] == $user_id){
                                $query = "SELECT username FROM webdev.users WHERE username = '".$row[2]."'";

                            }
                            else{
                                $query = "SELECT username FROM webdev.users WHERE username = '".$row[1]."'";
                            }
                            $other_user = pg_query($connect, $query);
                            $other_user = pg_fetch_row($other_user);

                            //var_dump($row);
                            //echo $row[2];
                            echo "<li><a href='dm.php?id=".$user_id."&convId=".$row[0]."'>---".$other_user. "+" .$user_id."---</a>----$</li>";

                        } 
                    
                      
                ?>
            </ul>
        </div>
        
    </body>


<?php

    if(!isset($_GET['id'])) // vérifie si id est dans l'url
    {
        header('location:menu.php');
    }
    else {
        $user_id = $_GET['id'];
    }

?>

</html>
