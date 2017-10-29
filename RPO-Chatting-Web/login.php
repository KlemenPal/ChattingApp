<?php
session_start();

// preusmeritev na registracijo, če je uporabnik kliknil na link
if (isset($_GET['register'])) {
    header('Location: registracija.php');
    exit();
}
// če je uporabnik submital formo grem preverjat v bazo uporabniško ime in geslo
if (isset($_POST['submit'])) {
    if (!empty($_POST['user']) && !empty($_POST['pass'])) {	// če ni bilo podanega parametra
		
		// shranjevanje uporabniškega imena in gesla iz post metode iz forme
		// mysqli_real_escape_string - escapes special chars in strings for SQL use
		// echo $_POST['user']; // test
        $user = $_POST['user'];
        $geslo = $_POST['pass'];
		
		// vključitev dokumenta, ki obravnava z MySQL bazo
        include_once 'dbcontrollers/Uporabnik.php';
        $upor = new Uporabnik();
		
		// preverjanje pravilnosti uporabniškega imena in gesla
        if ($upor->UserLogin($user, $geslo) == true) {
            $_SESSION['user']=$user;
            header('Location: index.php');
            exit();
        } else { // izpis, če geslo ni bilo pravilno
            include_once 'loginForm.php';
					?>
						<p align="center">Error! Username or password incorrect! Login failed.</p>
					<?php

        }
    } else {
		
        include_once 'loginForm.php';

?>
<p align="center">Error! Username or password incorrect! Login failed.</p>
<?php
    }
} else {
    include_once 'loginForm.php';
}?>

