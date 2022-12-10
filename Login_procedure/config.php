<?php
// Informations d'identification
// $servername = "localhost"; 
// $username = "root"; 
// $password = "";
// $database = "leocrush";
$host = "localhost";
$port = "5432";
$dbname = "pggrp4";
$user = "grp47oxh6hjegww";
$password = "99yXmThpFno";

 // Create a connection 
 // $conn = mysqli_connect($servername, 
     // $username, $password, $database);
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
// Vérifier la connexion
if($conn === false){
    die("ERREUR : Impossible de se connecter. " . pg_last_error($conn));
}/**/
?>