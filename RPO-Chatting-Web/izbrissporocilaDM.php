<?php
// baza
session_start();
$servername = "164.8.251.204";
$database = "student119";
$username = "student119";
$password = "mysql";


//connect to db
$db = mysqli_connect($servername, $username, $password, $database);

// za zdaj, ko je le 1 chat room, je to OK
// $sql = "SELECT * FROM chat ORDER BY id ASC;";
$id = $_GET["text"];
// $chatInfo = $_GET["nekaj"];

$sql = "DELETE FROM dmchat WHERE id = $id;";

mysqli_query($db, $sql);
/*
if (mysqli_query($db, $sql)) {
    // echo "<script>alert(\"Record deleted successfully!\");</script>";
} else {
    // echo "<script>alert(\"Neuspešen izbris!\");</script>";
}
*/

mysqli_close($db);
?>
