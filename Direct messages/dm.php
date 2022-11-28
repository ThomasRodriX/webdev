 
<!DOCTYPE html>
<html lang="en">
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
    $host = "https://pga.esilv.olfsoftware.fr/";
    $port = "5432";
    $dbname = "pggrp4";
    //$myPDO = new PDO("pgsql:host=$host;dbname=$dbname', $user, $password");
    $connect = pg_connect("host=$host dbname=$dbname user=$user password=$password");

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
                <p class="welcome">Heureux de vous voir, <b><?php echo $user_id; ?></b></p>
                <p><a id="retour_menu_dm" href="#">Revenir aux conversations</a></p>
            </div>
 
            <div id="chatbox">
            <?php
            /*
            // récupération des anciens messages si ils existent dans $result

            // A ENLEVER DES COMMENTAIRES LORSQUE CONNeCTION à la BDD 

            
            $oldMessages = pg_query($connect, "SELECT sender_id,text  FROM messages WHERE convo_id = $convId");

	        while ($row = pg_fetch_row($oldMessages)) {
		        echo "Sender ID: $row[0]  Message: $row[1]";
		        echo "<br />\n";
            }
            */
            ?>
            
            </div>
 
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="envoiMsg" type="submit" id="envoiMsg" value="Envoyer" />
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
                }
 
                setInterval (anciens_msg, 2500);
 
            });
        </script>
    </body>

<?php
    }
?>
</html>