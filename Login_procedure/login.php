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

    <?php
    require('config.php');
    session_start();

    if (isset($_POST['username']) && isset($_POST['password'])){
      $username = stripslashes($_REQUEST['username']);
      $username = pg_escape_string($conn, $username);
      $password = stripslashes($_REQUEST['password']);
      $password = pg_escape_string($conn, $password);
      $query = "SELECT * FROM users WHERE username='$username' and password='".hash('sha256', $password)."'";
      // print($query);
      $result = pg_query($conn,$query) or die(pg_last_error($conn));
      $rows = pg_num_rows($result);
      if($rows>0){
          $_SESSION['username'] = $username;
          // $user_name = $_SESSION['username'];
          header("Location: index.php");
          exit();
      }else{
            $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
      }
    }
  
    ?>


    <div class="registration-form">
        <form action="" method="post" name="login">
            <div class="form-icon">
                <span><i class="icon icon-user"></i></span>
            </div>
            <h2 class="box-title">Sign In</h2>
            <div class="form-group">
                <input type="text" class="form-control item" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control item" name="password" id="password" placeholder="Password" required>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-block create-account" name="submit">Log In</button>
            </div>
            <!-- Insert a "Lost password link" -->
            <p class="box-register">No account? <a href="register.php">Sign up</a></p>
            <?php if (!empty($message)) { ?>
            	<p class="errorMessage"><?php echo $message; ?></p>
            <?php } ?>
        </form>
        
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="script.js"></script>
</body>
</html>