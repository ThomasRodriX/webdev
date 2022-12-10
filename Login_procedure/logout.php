<?php
  // Initialiser la session
  session_start();
  
  //On détruit les variables de session
  session_unset ();
  
  // Détruire la session.
  if(session_destroy())
  {
    // Redirection vers la page de connexion
    header("Location: login.php");
  }
?>