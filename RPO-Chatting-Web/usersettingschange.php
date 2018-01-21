<?php
// baza
session_start();
$servername = "localhost";
$database = "chattingdb";
$username = "root";
$password = "root";


//connect to db
$db = mysqli_connect($servername, $username, $password, $database);

$name  = $_POST['ime'];
$pass = $_POST['geslo'];
$email = $_POST['email'];
$slika = $_POST['slika'];

echo $name + " ; " + $pass + " ; " + $email + " ; " + $slika + "<br>";

?>