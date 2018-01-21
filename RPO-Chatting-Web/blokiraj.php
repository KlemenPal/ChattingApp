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
$idBlok = $_GET["text"];

// nalaganje trenutnega uporabnnika iz seje (id)
$currentUserID = $_SESSION['user'];
$r = mysqli_query($db, "SELECT id FROM uporabniki WHERE username='$currentUserID';");
if(mysqli_num_rows($r) > 0){
	$row = mysqli_fetch_assoc($r);
	$idJaz = $row["id"];
} else {
	echo "<p>Napaka! </p>";
	exit;
}
mysqli_free_result($r);

$sql = "SELECT * FROM blokade WHERE id_uporabnik=$idJaz AND id_blokiran=$idBlok;";
$res = mysqli_query($db, $sql);
if(mysqli_num_rows($res) > 0){
	$sqlSt = "DELETE FROM blokade WHERE id_uporabnik=$idJaz AND id_blokiran=$idBlok;";
} else {
	$sqlSt = "INSERT INTO blokade (id_uporabnik,id_blokiran) VALUES ($idJaz,$idBlok);";
}
mysqli_query($db,$sqlSt);
mysqli_free_result($res);

mysqli_close($db);
?>
