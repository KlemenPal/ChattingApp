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

// soba -> ID + id userja + x spremenljivka (da vemo če promotamo ali demotamo)
$soba = $_SESSION['chat'];
$idU = $_GET['idUp'];
$x = $_GET['xvar'];
$idS = $s->nameToID($soba);

if($x == 0){
	// promotamo
	$sql = "UPDATE user_v_sobi SET admin=1 WHERE id_uporabnik=$idU AND id_sobe=$idS;";
	mysqli_query($db, $sql);
	
	mysqli_close($db);
	echo "Promotion executed!";
	return;
} else {
	// demotamo
	$sql = "UPDATE user_v_sobi SET admin=0 WHERE id_uporabnik=$idU AND id_sobe=$idS;";
	mysqli_query($db, $sql);
	
	mysqli_close($db);
	echo "Demotion executed!";
	return;
}

?>