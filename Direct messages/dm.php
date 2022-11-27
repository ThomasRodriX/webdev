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
            <div classname="messages">
            <?php
					foreach($chat_data as $chat)
					{
						if(isset($_SESSION['user_data'][$chat['userid']]))
						{
							$from = 'Me';
							$row_class = 'row justify-content-start';
							$background_class = 'text-dark alert-light';
						}
						else
						{
							$from = $chat['user_name'];
							$row_class = 'row justify-content-end';
							$background_class = 'alert-success';
						}

						echo '
						<div class="'.$row_class.'">
							<div class="col-sm-10">
								<div class="shadow-sm alert '.$background_class.'">
									<b>'.$from.' - </b>'.$chat["msg"].'
									<br />
									<div class="text-right">
										<small><i>'.$chat["created_on"].'</i></small>
									</div>
								</div>
							</div>
						</div>
						';
					}
					?>
					</div>
            </div>
          <div className="nouveau_msg">
                <div className="creer_msg">
                    <form id="monForm" action="" method="post">
                        <textarea className="text_area_new_msg" placeholder="Ecrivez votre message"></textarea>
                        <button type="submit">Envoyer</button>
                    </form>
                </div>    
            </div>
        </div>
        
        <p> <a href="index.php"> Retour à l'accueil </a> </p>
    </body>

</html>

<?php
curent_user = $_GET['user'] // id du user courant
conv_id = $_GET['conv_id'] // id de la conversation courante

// récupération des messages de la convo
$query = "SELECT 'sender_id', 'text', 'date' FROM `messages` WHERE 'convo_id'='conv_id';
VALUES ('$sender_id', '$text', '$date')";


?>
