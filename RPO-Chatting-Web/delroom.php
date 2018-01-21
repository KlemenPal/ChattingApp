<?php
// baza

session_start();
$servername = "164.8.251.204";
$database = "student119";
$username = "student119";
$password = "mysql";


//connect to db
$db = mysqli_connect($servername, $username, $password, $database);

// soba
$soba = $_SESSION['chat'];

// izbris...
$sql = "DELETE FROM sobe WHERE name='$soba';";
mysqli_query($db, $sql);
mysqli_close($db);

// unset seja in sporocilo
unset($_SESSION['chat']);
echo "Successfully deleted room $soba!";

return;

?>