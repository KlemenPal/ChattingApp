<?php
// baza
session_start();
$servername = "164.8.251.204";
$database = "student119";
$username = "student119";
$password = "mysql";


//connect to db
$db = mysqli_connect($servername, $username, $password, $database);

// uporabnik class

include_once 'dbcontrollers/Uporabnik.php';
$u = new Uporabnik();

// ime -> id
$imePrij = $_GET["text"];
$imeJaz = $_SESSION['user'];

// preverjanje RegEx
if(preg_match("/^[a-zA-Z0-9_ ]*$/", $imePrij) == 1) {
	// OK
} else {
	echo "You inserted irregular input (Letter, Space or Number allowed).";
	return;
}

$r = $u->PreveriUsername($imePrij);

if(mysqli_num_rows($r) == 0){
	echo "User $imePrij doesn't exist!";
	mysqli_close($db);
	return;
} else {
	
}

// dodajanje prijateljev
$idPrij = $u->PretvoriImeId($imePrij);
$idJaz = $u->PretvoriImeId($imeJaz);

if($idPrij == $idJaz){
	echo "You cannot add yourself as a friend...";
	return;
}

// preverjanje če sta že prijatelja, ne rabiš preverjati obojestransko
$sql = "SELECT * FROM prijatelji WHERE id_up1=$idPrij AND id_up2=$idJaz;";
$result = mysqli_query($db, $sql);
if(mysqli_num_rows($result) > 0){
	mysqli_close($db);
	
	echo "$imePrij is already your friend.";
	return;
}

$sql = "INSERT INTO prijatelji (id_up1, id_up2) VALUES ($idJaz,$idPrij);";
mysqli_query($db, $sql);

$sql = "INSERT INTO prijatelji (id_up1, id_up2) VALUES ($idPrij,$idJaz);";
mysqli_query($db, $sql);

mysqli_close($db);

echo "Successfully added friend $imePrij!";
return;
?>
