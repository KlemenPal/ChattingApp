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

$sql = "SELECT * FROM uporabniki WHERE username='$uname';";
$result = mysqli_query($db, $sql);
if (mysqli_num_rows($result) == 1) { // če je 1 rezultat
        while ($row = mysqli_fetch_assoc($result)) {
			$userId = $row['id'];
	}
}

mysqli_free_result($result);

$s = $_SESSION['chat'];
$r = mysqli_query($db, "SELECT id FROM sobe WHERE name='$s';");

if(mysqli_num_rows($r) > 0){
	$row = mysqli_fetch_assoc($r);
	$idS = $row["id"];
} else {
	echo "<script> alert(\"Napaka pri vnosu podatkov\"); </script>";
	exit;
}

$esctext = mysqli_real_escape_string($db,$text);
$sql = "INSERT INTO chat (message, id_uporabnik, id_sobe) VALUES ('$esctext', $userId, $idS);";
// $sql = "INSERT INTO chat (message, id_uporabnik, id_sobe) VALUES ('Prvi test', 1, 1);"; // statično dela
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