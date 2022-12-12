 
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <link href="./css/styleDM.css" rel = "stylesheet" type = "text/css">
        <link rel="stylesheet" href="css/navbar.css">
        <title>chat DM</title>
        <meta name="description" content="chatbox" />
    </head>
    <body>
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

    <?php
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

    if(!isset($_GET['id'])) // vérifie si id est dans l'url du client est dans l'url
    {
        header('location:https://grp4.esilv.olfsoftware.fr/app.php');
    }
    else {
        $user_id = $_GET['id']; 
        if(isset($_GET['convId'])){ // check si conversation id est dans l'url
	        $convId = $_GET['convId'];
        }
        else{
	        header('location:dm_menu.php?id='.$user_id);
        }


    ?>
        <div id="wrapper">
            <div id="menu">
                <p class="welcome">Heureux de vous revoir, <b><?php 
                    $query = "SELECT username FROM webdev.users WHERE id = '".$user_id."'";
                    $username = pg_query($connect, $query);
                    $username = pg_fetch_row($username);
                    $username = $username[0];
                echo $username; 
                ?></b> !!!</p>
            </div>
            <div id="retourMenu">
                <p><a id="retour_dm_menu" href="dm_menu.php">Revenir au menu</a></p>
            </div>

            <div class="">

                <div style="cursor:pointer;" style class="image-upload">
                    <label style="cursor:pointer;" for="file-input">
                    <img class="profile-image-left" id="picture" style="cursor:pointer;"onClick="onFileSelected()" src="https://imgs.search.brave.com/e6dWgupmtPq1AxT6xf0CYeqybta_lGP53Hj-hgj4ZKI/rs:fit:711:225:1/g:ce/aHR0cHM6Ly90c2U0/Lm1tLmJpbmcubmV0/L3RoP2lkPU9JUC5t/MnZUUy1oc1JPc29a/VnlfRnBiY3hBSGFF/OCZwaWQ9QXBp" alt=""><img class="profile-image-right" id="picture" style="cursor:pointer;"onClick="onFileSelected()" src="https://images.unsplash.com/photo-1513721032312-6a18a42c8763?w=152&h=152&fit=crop&crop=faces" alt="">
                    </label>
                    <input style="display:none;" id="file-input" type="file"  accept="image/*" onchange="document.getElementById('picture').src = window.URL.createObjectURL(this.files[0])"/>
                </div>
            </div>
 
            <div id="chatbox">
            <?php
            
            // récupération des anciens messages si ils existent dans $result
            
            $query = "SELECT * FROM webdev.messages WHERE convo_id = '".$convId."'";
            //$query = "SELECT * FROM users WHERE email = '".$_POST['email']."' AND password = '$password_md5'";

            $oldMessages = pg_query($connect, $query); 

            //$sender="";
            echo "<div id=text_conv_area>";
	        while ($row = pg_fetch_row($oldMessages)) {
                $date = $row[5];
                if($row[2] == $user_id){
                    $sender = "Vous";
                    echo "<p id='vous'>$date |  <strong>$sender</strong> :  $row[3]</p>";
                }
                else{
                    $query = "SELECT user_0, user_1 FROM webdev.conversations WHERE id = '".$convId."'";
                    $people = pg_query($connect, $query);
                    $people = pg_fetch_row($people);
                    if($people[0] == $user_id){
                        $sender = $people[1];
                    }
                    else{
                        $sender = $people[0];
                    }
                    $query = "SELECT username FROM webdev.users WHERE id = '".$sender."'";
                    $sender = pg_query($connect, $query);
                    $sender = pg_fetch_row($sender);
                    $sender = $sender[0];

                    echo "<p id='lui'>$date |  <strong>$sender</strong> :  $row[3]</p>";
                }
		        
            }
            echo "</div>";
            
            ?>
            
            </div>
 
            <form method="post">
                <input name="usermsg" type="text" id="usermsg" value=""/>
                <p><input type="submit" value="Envoyer"></p>
            </form>
        </div>
    </body>

    <?php
    }
    // add message to db
    if(isset($_POST['usermsg'])){
        $text = $_POST['usermsg'];
        $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".'pseudo'."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
        // connect to postgres
        $user = "grp47oxh6hjegww"; 
        $password = "99yXmThpFno";
        $host = "esilv.olfsoftware.fr";
        $port = "5432";
        $dbname = "pggrp4";
        $connect = pg_connect("host=$host port=5432 dbname=$dbname user=$user password=$password");
        if(!$connect){
            echo "Unable to connect to the database.";
        }
        $id = $_GET['id'];
        
        $time = time();
        $date = date("Y-m-d H:i:s", $time);
    

        $query = "INSERT INTO webdev.messages VALUES ('$time', '$convId', '$id', '$text', null, '$date')";
        $newMessages = pg_query($connect, $query);
        if (!$newMessages) {
            echo "Une erreur s'est produite.\n";
            exit;
        }
        else{
            header('location:dm.php?id='.$id.'&convId='.$convId);
        }
    }

    ?>
</html>