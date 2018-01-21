<?php
session_start();

if (isset($_POST['submit'])) {
    if (!empty($_POST['user']) && !empty($_POST['pass'])) {
		
		// shranjevanje uporabniškega imena in gesla iz post metode iz forme
        $user = $_POST['user'];
        $geslo = $_POST['pass'];

        include_once 'dbcontrollers/Uporabnik.php';
        $upor = new Uporabnik();
		
		// registracija uporabnika
		$abc = $upor->PreveriUsername($user);
        if(mysqli_num_rows($abc) == 0){	// če uporabniško ime še ne obstaja se lahko registrira
			$upor->RegistracijaUporabnika($user,$geslo);
			echo '<script language="javascript">';
			echo 'alert("Registracija uspešna.")';
			echo '</script>';
			include_once 'registracijaForm.php';
        }
        else{ // če uporabniško ime obstaja izpiši napako
            include_once 'registracijaForm.php';
            ?><p align="center"><b>Username already exists.</b></p><?php
        }
    }
    else {
        include_once 'registracijaForm.php';
        ?>
<p align="center"><b>Username and password is required.</b></p>
<?php
    }
} else {
        include_once 'registracijaForm.php';
?>

		<p align="center"><b>Input fields have to be correct (GREEN).<b></p>
<?php
    }
?>