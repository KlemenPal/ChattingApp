<?php

// TO JE TESTNI PRIMER ZA POVEZAVO NA BAZO IN QUERY

// povezava na bazo
$servername = "sql11.freemysqlhosting.net";
$database = "sql11201543";
$username = "sql11201543";
$password = "RNWDUNINqK";

$connect = mysqli_connect($servername, $username, $password, $database);

// pregled tabel
$sql = "SHOW TABLES FROM $database;";
$result = mysqli_query($connect, $sql);

while ($row = mysqli_fetch_row($result)) {
	echo "Tabele: {$row[0]} <br><br>";
}

// pregled uporabnikov in gesel...
$query = "SELECT * FROM uporabnik";
$result = mysqli_query($connect, $query, MYSQLI_USE_RESULT);

while($row = mysqli_fetch_row($result))
{	
	echo "$row[0] - $row[1] - $row[2] <br>";
}

// ostali testi
// $query = "DELETE FROM uporabnik WHERE username = 'KlemenP';";
// $result = mysqli_query($connect, $query);


mysqli_free_result($result);
mysqli_close($connect);

?>

<?php 



/*
$servername = "sql11.freemysqlhosting.net";
$database = "sql11201543";
$username = "sql11201543";
$password = "RNWDUNINqK";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
  echo "Connected successfully";
 */
?>
