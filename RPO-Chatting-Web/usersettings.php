<?php
session_start(); // začne novo sejo ali nadaljuje s prejšnjo


if(!isset($_SESSION['user'])){ // seje za uporabnika ni - ni se vpisal

	echo '<script language="javascript">';
	echo 'alert("Login expired, you will be redirected.")';
	echo '</script>';
    header("Location: login.php");
	exit;
} 

// če je uporabnik submital formo pošljem query na bazo
if (isset($_POST['submit'])) {
	// shranjevanje uporabniškega imena in gesla iz post metode iz forme
	// mysqli_real_escape_string - escapes special chars in strings for SQL use
	// echo $_POST['user']; // test
    $user = $_POST['user'];
    $geslo = $_POST['pass'];
	$email = $_POST['mail'];
	$image = $_POST['image'];
	
	// vključitev dokumenta, ki obravnava z MySQL bazo
    include_once 'dbcontrollers/Uporabnik.php';
    $upor = new Uporabnik();
	// vrnilo je 0, uporabnik še ne obstaja...
	$a = $upor->PosodobiPodatke($user,$geslo,$email,$image);
	session_destroy();
	// header("Location: login.php");
	echo "<script> location.href='login.php'; </script>";
	exit;
}
	
	// ... koda
	/*
	ko končaš s spremembami naredi session destroy in nato pojdi na login.php
	*/
 else {
	
    include_once 'usersettingsForm.php';
}