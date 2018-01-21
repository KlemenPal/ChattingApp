<?php
// baza

session_start();
$servername = "164.8.251.204";
$database = "student119";
$username = "student119";
$password = "mysql";


//connect to db
$db = mysqli_connect($servername, $username, $password, $database);

// vključitev sobe
include_once 'dbcontrollers/Soba.php';
$s = new Soba();

// soba -> ID + id userja
$soba = $_SESSION['chat'];
$idDeleted = $_GET['text'];
$idS = $s->nameToID($soba);
// izbris...
$sql = "DELETE FROM chat WHERE id_sobe=$idS AND id_uporabnik=$idDeleted;";
mysqli_query($db, $sql);

$sql = "DELETE FROM user_v_sobi WHERE id_sobe=$idS AND id_uporabnik=$idDeleted;";
mysqli_query($db, $sql);

mysqli_close($db);

echo "Action successful!";

return;

?>