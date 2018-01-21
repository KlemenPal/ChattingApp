<?php
// baza
session_start();
$servername = "164.8.251.204";
$database = "student119";
$username = "student119";
$password = "mysql";


//connect to db
$db = mysqli_connect($servername, $username, $password, $database);

// Soba + Uporabnik classa
include_once 'dbcontrollers/Soba.php';
$s = new Soba();
include_once 'dbcontrollers/Uporabnik.php';
$u = new Uporabnik();


// ime sobe + ime trenutnega uporabnika (ki bo admin)
$imeSobe = $_GET["text"];
$imeJaz = $_SESSION['user'];

// preverjanje RegEx
if(preg_match("/^[a-zA-Z0-9_ ]*$/", $imeSobe) == 1) {
	// OK
} else {
	echo "You inserted irregular input (Letter, Space or Number allowed).";
	return;
}

// pretvorba imena v v id
$idJaz = $u->PretvoriImeId($imeJaz);

// preverjanje ce soba ze obstaja
$sql = "SELECT * FROM sobe WHERE name='$imeSobe';";
$r = mysqli_query($db, $sql);
if(mysqli_num_rows($r)>0){
	mysqli_close($db);
	echo "Room $imeSobe already exists!";
	return;
}

// dodajanje sobe...
$sql = "INSERT INTO sobe (name) VALUES ('$imeSobe');";
mysqli_query($db, $sql);

// pridobitev id-ja sobe
$IDS = $s->nameToID($imeSobe);
$sql = "INSERT INTO user_v_sobi (id_uporabnik, id_sobe, admin) VALUES ($idJaz, $IDS, 2);";
mysqli_query($db, $sql);

mysqli_close($db);

echo "Successfully added room $imeSobe!";
return;

?>
