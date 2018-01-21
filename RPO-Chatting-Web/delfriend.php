<?php
// baza
session_start();
$servername = "164.8.251.204";
$database = "student119";
$username = "student119";
$password = "mysql";

// nenastavljen prijatelj
if(!isset($_SESSION['DMchat'])){
	echo "Unset friend...";
	return;
}

//connect to db
$db = mysqli_connect($servername, $username, $password, $database);

// uporabnik class

include_once 'dbcontrollers/Uporabnik.php';
$u = new Uporabnik();

// ime -> id
$imePrij = $_SESSION['DMchat'];
$imeJaz = $_SESSION['user'];


$r = $u->PreveriUsername($imePrij);

// napaka
if(mysqli_num_rows($r) == 0){
	echo "User $imePrij doesn't exist or is undefined!";
	return;
} else {
	
}

// izbris...
$idPrij = $u->PretvoriImeId($imePrij);
$idJaz = $u->PretvoriImeId($imeJaz);

if($idPrij == $idJaz){
	echo "You cannot remove yourself...";
	return;
}

$sql = "DELETE FROM prijatelji WHERE id_up1=$idPrij AND id_up2=$idJaz;";
mysqli_query($db, $sql);

$sql = "DELETE FROM prijatelji WHERE id_up2=$idPrij AND id_up1=$idJaz;";
mysqli_query($db, $sql);

mysqli_close($db);

// unset seja in sporocilo
unset($_SESSION['DMchat']);
echo "Successfully deleted friend $imePrij!";

return;

?>