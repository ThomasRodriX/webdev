<!DOCTYPE html >

<html lang="fr"> 
    
    <head>
        <meta charset="utf-8">
        <link href="./css/styleDM.css" rel = "stylesheet" type = "text/css">
        <link rel="stylesheet" href="css/navbar.css">
        <title> Mes DM </title>
    </head>
    <header>

    <div class="navigation">
    <div class="logo">
      <a class="no-underline" href="#">
        Leo Crush
      </a>
    </div>
    <div class="navigation-search-container">
      <i class="fa fa-search"></i>
      <input class="search-field" type="text" placeholder="Search">
      <div class="search-container">
        <div class="search-container-box">
          <div class="search-results">

          </div>
        </div>
      </div>
    </div>
    <div class="navigation-icons">
      <a onclick="var url = window.location.toString(); window.location.href = url.replace(/\/[^\/]*$/, '/app.php');" class="navigation-link">
        <i class="far fa-compass iconActive"></i>
      </a>
      <a onclick="var url = window.location.toString(); window.location.href = url.replace(/\/[^\/]*$/, '/profile.php');" class="navigation-link">
        <i class="far fa-user-circle icon"></i>
      </a>
      <!-- <a href="https://instagram.com/mimoudix" id="signout" class="navigation-link">
        <i class="fas fa-sign-out-alt icon"></i>
      </a> -->
      <form method="post">
        <input type="submit" name="logout"
          class="button" value="Logout" 
        />
      </form>
    </div>
  </div>

	<div class="container">

		<div class="profile">

			<div class="profile-image">

			<div style="cursor:pointer;" style class="image-upload">
		     	<label style="cursor:pointer;" for="file-input">
				   <img class="picture" id="picture" style="cursor:pointer;"onClick="onFileSelected()" src="https://images.unsplash.com/photo-1513721032312-6a18a42c8763?w=152&h=152&fit=crop&crop=faces" alt="">
				</label>
				<input style="display:none;" id="file-input" type="file"  accept="image/*" onchange="document.getElementById('picture').src = window.URL.createObjectURL(this.files[0])"/>
            </div>

			</div>

			<div class="profile-user-settings">

				<h1 class="profile-user-name"><?php 
                    $user_id = $_GET['id'];
                    $user = "grp47oxh6hjegww"; 
                    $password = "99yXmThpFno";
                    $host = "esilv.olfsoftware.fr";
                    $port = "5432";
                    $dbname = "pggrp4";
                
                    $connect = pg_connect("host=$host port=5432 dbname=$dbname user=$user password=$password");
                    $query = "SELECT username FROM webdev.users WHERE id = '".$user_id."'";
                    $username = pg_query($connect, $query);
                    $username = pg_fetch_row($username);
                    $username = $username[0];
                echo $username;
                ?></h1>

			</div>
		</div>
		<!-- End of profile section -->

	</div>
	<!-- End of container -->

</header>
    <body>
        <h1 id=titre></h1>
        <div className="mes_conversations">
          <h2 id=mes_convs>Mes conversations</h2>
            <ul>
                <?php
                    if(!isset($_GET['id'])) // vérifie si id est dans l'url du client est dans l'url
                    {
                        header('location:https://grp4.esilv.olfsoftware.fr/');
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
                        echo "<div id=conv_area>";
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

                            echo "<li><a id=link href='dm.php?id=".$user_id."&convId=".$row[0]."'>".$username[0]."</a></li>";
                        }
                        echo"</div>";
                          
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
        header('location:https://grp4.esilv.olfsoftware.fr/');
    }
    else {
        $user_id = $_GET['id'];
    }

?>

</html>
