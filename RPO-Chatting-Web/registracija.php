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
			include_once 'RegistracijaForm.php';
        }
        else{ // če uporabniško ime obstaja izpiši napako
            include_once 'RegistracijaForm.php';
            ?><p align="center">Uporabnik s tem imenom že obstaja</p><?php
        }
    }
    else {
        include_once 'RegistracijaForm.php';
        ?>
<p align="center">Uporabniško ime in geslo je obvezno.</p>
<?php
    }
} else {
        include_once 'RegistracijaForm.php';
?>
<?php
    }
?>