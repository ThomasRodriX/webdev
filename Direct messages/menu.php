

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title> Menu </title>
    </head>
    <body>
        <p> Menu </p>
    </body>
</html
<?php

$user = "grp47oxh6hjegww"; 
$password = "99yXmThpFno";
$host = "pga.esilv.olfsoftware.fr";
$port = "5432";
$dbname = "pggrp4";
//$myPDO = new PDO("pgsql:host=$host;dbname=$dbname', $user, $password");
$connect = pg_connect("host=$host dbname=$dbname user=$user password=$password");

?>