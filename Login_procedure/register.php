<?php
require('config.php');
$message_erreur = "";
if (isset($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password'])){
  // récupérer le nom d'utilisateur et supprimer les antislashes ajoutés par le formulaire
  $username = stripslashes($_REQUEST['username']);
  $username = pg_escape_string($conn, $username); 
  // récupérer l'email et supprimer les antislashes ajoutés par le formulaire
  $email = stripslashes($_REQUEST['email']);
  $email = pg_escape_string($conn, $email);
  // récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
  $password = stripslashes($_REQUEST['password']);
  $password = pg_escape_string($conn, $password);

  $telephone= $_REQUEST["phone-number"];
  $myuuid = guidv4();

  // $select = mysqli_query($conn, "SELECT * FROM users WHERE username ='$username' AND email ='$email'");
  $select = pg_query($conn, "SELECT * FROM users WHERE username ='$username' AND email ='$email'");
  if(pg_num_rows($select)) {
    $message_erreur .="Ce nom d'utilisateur ou cet email existe déjà";
  }
  else {
  //requéte SQL + mot de passe crypté
  $query = "INSERT into users (id,username, email, password)
              VALUES ('$myuuid','$username','$email', '".hash('sha256', $password)."')";
  // Exécuter la requête sur la base de données

  
  $res = pg_query($conn, $query) or die(pg_last_error($conn));
  header('location:login.php');
  // exit();
  }

}

  // generate random id
  function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LeoCrush</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="registration-form">
        <form action="" method="post">
            <div class="form-icon">
                <span><i class="icon icon-user"></i></span>
            </div>
            <h2> Sign Up</h2>
            <div id="reponse"><?php
              if (strlen($message_erreur) > 0) {
                print("<p class=\"msgerreur\">".nl2br($message_erreur)."</p>");
              }?>
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control item" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="phone-number" id="phone-number" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="birth-date" id="birth-date" placeholder="Birth Date" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-block create-account" name="submit">Create Account</button>
            </div>
            <p class="box-register">Already have an account? <a href="login.php">Sign in here</a></p>
        </form>

    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

