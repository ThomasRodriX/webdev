 
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
 
        <title>Tuts+ Chat Application</title>
        <meta name="description" content="chatbox" />
    </head>
    <body>
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
        header('location:menu.php');
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
                <p class="welcome">Heureux de vous revoir, <b><?php echo $user_id; ?></b></p>
                <p><a id="retour_dm_menu" href="dm_menu.php">Revenir aux conversations</a></p>
            </div>
 
            <div id="chatbox">
            <?php
            
            // récupération des anciens messages si ils existent dans $result
            

            $query = "SELECT * FROM webdev.messages WHERE convo_id = '".$convId."'";
            //$query = "SELECT * FROM users WHERE email = '".$_POST['email']."' AND password = '$password_md5'";

            $oldMessages = pg_query($connect, $query); 

            $sender="";
	        while ($row = pg_fetch_row($oldMessages)) {
                if($row[2] == $user_id){
                    $sender = "Vous";
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
                }
		        echo "$sender :  Message: $row[3]";
		        echo "<br />\n";
            }
            
            ?>
            
            </div>
 
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="envoiMsg" type="submit" id="envoiMsg" value="Envoyer" onclick=send()/>
            </form>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
          // jQuery Document
            $(document).ready(function () {
                $("#envoiMsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });

                function anciens_msg() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll 
                    /*
                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); // ajoute le msg dans la chatbox
 
                            //Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll 
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll jusuq'au dernier msg
                            }   
                        }
                    });
                    */
                }

                setInterval (anciens_msg, 2500);
 
            });
        
        </script>
    </body>

<?php
    }
    /*
    function send(){
        $msg = htmlspecialchars($_POST['envoiMsg']);
        
        $newMessages = pg_query($connect, 'INSERT INTO webdev.messages VALUES (' $convId', '$id', '$text', '', 'NOW()')');
        $result = pg_query($dbconn, $query);
    } */
    

?>
</html>