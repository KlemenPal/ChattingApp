<?php
// baza
session_start();
$servername = "164.8.251.204";
$database = "student119";
$username = "student119";
$password = "mysql";

//connect to db
$db = mysqli_connect($servername, $username, $password, $database);

// pridobitev username + tekst
$uname = $_SESSION['user'];
$text = $_GET["text"];

// kdo pošilja sporočilo (ti v svoji seji)
$result = mysqli_query($db, "SELECT * FROM uporabniki WHERE username='$uname';");
if (mysqli_num_rows($result) == 1) { // če je 1 rezultat
        while ($row = mysqli_fetch_assoc($result)) {
			$idPosiljatelj = $row["id"];
	}
}
mysqli_free_result($result);

// kdo prejema sporočilo
$sendername = $_SESSION['DMchat'];
$result = mysqli_query($db, "SELECT * FROM uporabniki WHERE username='$sendername';");

if(mysqli_num_rows($result) > 0){
	$row = mysqli_fetch_assoc($result);
	$idPrejemnik = $row["id"];
} else {
	echo "<script> alert(\"Napaka pri vnosu podatkov\"); </script>";
	exit;
}
mysqli_free_result($result);

// vnos
$esctext = mysqli_real_escape_string($db,$text);
$sql = "INSERT INTO dmchat (message, id_posiljatelj, id_prejemnik) VALUES ('$esctext', $idPosiljatelj, $idPrejemnik);";
$result = mysqli_query($db, $sql);
if(!$result) {
	echo "Napaka v povpraševanju.\n";
}
else {
	// echo "Povpraševanje uspešno.\n";
}
mysqli_free_result($result);

mysqli_close($db);
?>