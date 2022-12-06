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
                    if(pg_num_rows($conv) != 0){
                        while($row = pg_fetch_row($conv)){
                            if($row[1] == $user_id){
                                $vousId = $row[1];
                                $pasVousId = $row[2];
                            }
                            else{
                                if($row[2] == $user_id){
                                    $vousId = $row[2];
                                    $pasVousId = $row[1];
                                }
                                else{
                                    echo "Erreur";
                                    $vousId = "Erreur";
                                }
                            }

                            // récupère le usernamer de l'autre utilisateur
                            $query = "SELECT username FROM webdev.users WHERE id = '".$pasVousId."'";
                            $username = pg_query($connect, $query);
                            $username = pg_fetch_row($username);

                            echo "<li><a href='dm.php?id=".$user_id."&convId=".$row[0]."'>".$username[0]."</a></li>";
                        }
                          
                    }
                    else{
                        echo "Vous n'avez pas de conversations";
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
