<?php
session_start(); // začne novo sejo ali nadaljuje s prejšnjo

echo "This a first / test page for a Chatting Website. <br>";
echo "This page is used for redirections.";
if(!isset($_SESSION['user'])){ // seje za uporabnika ni - ni se vpisal
	// izpis napake in preusmeritev na stran za login in registracijo
	// skripta za "alert" o preusmeritvi
	echo '<script language="javascript">';
	echo 'alert("Login expired, you will be redirected shortly.")';
	echo '</script>';
    header( "refresh:3; url=login.php" ); // po 3 sekundah te preusmeri
} else {	// uporabnik se je uspešno vpisal
	echo "<br><br><br>Login Successful, welcome " . $_SESSION['user'] . ".<br>
			<a href=\"logout.php\">LOG OUT</a>";
}
?>