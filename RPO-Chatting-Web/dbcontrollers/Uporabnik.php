<?php

class Uporabnik {
    
    private $id;
    private $username;
    private $password;
    private $dbcon;
	
	// kreiranje povezave
    public function __construct() {
		
		/*
		$servername = "sql11.freemysqlhosting.net";
		$database = "sql11201543";
		$username = "sql11201543";
		$password = "RNWDUNINqK";
		
		
		$servername = "localhost";
		$database = "chattingdb";
		$username = "root";
		$password = "root";
		*/
		
		$servername = "164.8.251.204";
		$database = "student119";
		$username = "student119";
		$password = "mysql";

		$this->dbcon = mysqli_connect($servername, $username, $password, $database);
	}
        
    public function __destruct() {
		mysqli_close($this->dbcon);
    }

    public function UserLogin($user,$pass){
		// prvi test: prviuser, passworduser
		
		/*
		// TESTIRANJE POVEZAVE
		$sql = "SHOW TABLES";
		$result = mysqli_query($this->dbcon, $sql);
		
		while ($row = mysqli_fetch_row($result)) {
			echo "Tabele: {$row[0]} <br>";
		}
		*/
		$sql = "SELECT * FROM uporabniki WHERE username='$user' and password='$pass'; ";
        $result = mysqli_query($this->dbcon, $sql);
        if (!$result) {
            echo "Napaka v povpraševanju.\n";
            exit;
        }
        if (mysqli_num_rows($result) == 1) {
            mysqli_free_result($result);
            return true;
        }
		
        mysqli_free_result($result);
        return false;
    }
	
	public function RegistracijaUporabnika($user,$geslo){
		/*
		if(PreveriUsername($user)){
			echo '<p>Tak username ze obstaja</p>';
			exit;
		}
		*/
        $sql = "INSERT INTO uporabniki (username,password) VALUES "
                . "('$user','$geslo');";
        $result = mysqli_query($this->dbcon, $sql);
        if(!$result) {
            echo "Napaka v povpraševanju.\n";
            exit;
        }
        else {
            ?><!--<p align="center">Registracija uspešna.</p>--><?php
        }
    }
    
	public function PreveriUsername($user){
		$sql = "SELECT * FROM uporabniki WHERE username='$user';";
        $result = mysqli_query($this->dbcon,$sql);
		/*
        if(mysqli_num_rows($result) == 0) {
            return 0;
        } else {
			return 1;
		}
		*/
		return $result;
	}
	
	public function SeznamUporabnikov(){
		$sql = "SELECT * FROM uporabniki;";
		$result = mysqli_query($this->dbcon, $sql);
		// izpis sob v seznam opcij (select)
		
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$username = htmlspecialchars($row["username"]);
				if($username != $_SESSION['user']){
					echo "<option value=\"$username\">$username</option>";
				}
			}
			mysqli_free_result($result);
			return true;
		}
		
		mysqli_free_result($result);
		return false;
	}
	
	public function SeznamPrijateljev(){
		$currName = $_SESSION['user'];
		$currId = $this->PretvoriImeId($currName);
		
		$sql = "SELECT * FROM prijatelji WHERE id_up1=$currId;";
		$result = mysqli_query($this->dbcon, $sql);
		
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				
				$idPrij = $row["id_up2"];
				$username = $this->PretvoriIdIme($idPrij);
				
				echo "<option value=\"$username\">$username</option>";
			}
		} else {
			//echo "<script> alert(\"You currently have no friends added!\"); </script>";
		}
		
		mysqli_free_result($result);
		return true;
	}
	
	public function PosodobiPodatke($user,$pass,$email,$slika){
		$res = $this->PreveriUsername($user);
		if(mysqli_num_rows($res) == 0 && strlen($pass) > 3){
			$sql = "UPDATE uporabniki SET username='$user' WHERE username='$user';";
			mysqli_query($this->dbcon, $sql);
		} else {
			$user = $_SESSION['user'];
			echo "<script> alert(\"Username exists and was unchanged.\"); </script>";
		}
		
		if(strlen($pass) > 3){
			$sql = "UPDATE uporabniki SET password='$pass' WHERE username='$user';";
			mysqli_query($this->dbcon, $sql);
		} else {
			echo "<script> alert(\"Password was too short and stays unchanged...\"); </script>";
		}
		
		$sql = "UPDATE uporabniki SET email='$email' WHERE username='$user';";
		mysqli_query($this->dbcon, $sql);
		
		$slikaEsc = mysqli_real_escape_string($this->dbcon, $slika);
		
		$sql = "UPDATE uporabniki SET slika='$slikaEsc' WHERE username='$user';";
		mysqli_query($this->dbcon, $sql);
			
		return true;
	}
	
	public function PretvoriImeId($user){
		$sql = "SELECT * FROM uporabniki WHERE username='$user';";
		$res = mysqli_query($this->dbcon, $sql);
		if(mysqli_num_rows($res) != 1){
			echo "<script> alert(\"Name doesn't exist\"); </script>";
		} else {
			$vrst = mysqli_fetch_assoc($res);
			$id = $vrst["id"];
			return $id;
		}
		return;
	}
	
	public function PretvoriIdIme($id){
		$sql = "SELECT * FROM uporabniki WHERE id=$id;";
		$res = mysqli_query($this->dbcon, $sql);
		if(mysqli_num_rows($res) != 1){
			echo "<script> alert(\"Name doesn't exist\"); </script>";
		} else {
			$vrst = mysqli_fetch_assoc($res);
			$u = $vrst["username"];
			return $u;
		}
		return;
	}
	
	public function PreveriAdmin($user,$soba){
		// $soba mora biti ID...
		// pridobitev id-ja uporabnika
		/*
		$sql = "SELECT * FROM uporabniki WHERE username='$user';";
		$result = mysqli_query($this->dbcon, $sql);
		$vrst = mysqli_fetch_assoc($result);
		$idUp = $vrst["id"];
		mysqli_free_result($result);
		*/
		$idUp = $this->PretvoriImeId($user);
		
		// preverjanje, če je uporabnik v sobi admin
		$sql = "SELECT * FROM chat WHERE id_uporabnik=$idUp AND id_sobe=$soba LIMIT 1;";
		$result = mysqli_query($this->dbcon, $sql);
		$row = mysqli_fetch_assoc($result);
		if($row["admin"] == 1){
			return true;
		} else {
			return false;
		}
		mysqli_free_result($result);
	}
	
	public function PreveriAdminVSobi($user,$soba){
		// $soba mora biti ID...
		// pridobitev id-ja uporabnika
		/*
		$sql = "SELECT * FROM uporabniki WHERE username='$user';";
		$result = mysqli_query($this->dbcon, $sql);
		$vrst = mysqli_fetch_assoc($result);
		$idUp = $vrst["id"];
		mysqli_free_result($result);
		*/
		$idUp = $this->PretvoriImeId($user);
		
		// preverjanje, če je uporabnik v sobi admin
		$sql = "SELECT * FROM user_v_sobi WHERE id_uporabnik=$idUp AND id_sobe=$soba;";
		$result = mysqli_query($this->dbcon, $sql);
		$row = mysqli_fetch_assoc($result);
		$a = $row['admin'];
		mysqli_free_result($result);
		
		return $a;
	}
	
	public function PrevAdmin($user,$soba){
		// $soba mora biti ID...
		// pridobitev id-ja uporabnika
		
		$sql = "SELECT * FROM sobe WHERE name='$soba';";
		$result = mysqli_query($this->dbcon, $sql);
		$vrst = mysqli_fetch_assoc($result);
		$idS = $vrst["id"];
		mysqli_free_result($result);
		
		$idUp = $this->PretvoriImeId($user);
		
		// preverjanje, če je uporabnik v sobi admin
		$sql = "SELECT * FROM chat WHERE id_uporabnik=$idUp AND id_sobe=$idS LIMIT 1;";
		$result = mysqli_query($this->dbcon, $sql);
		$row = mysqli_fetch_assoc($result);
		if($row["admin"] == 1){
			return true;
		} else {
			return false;
		}
		mysqli_free_result($result);
	}
	
	public function JeBlokiran($current, $idBlok){
		// pridobitev id-ja uporabnika (nepotrebno, ker ga že prej dobiš...)
		/*
		$sql = "SELECT * FROM uporabniki WHERE username='$current';";
		$result = mysqli_query($this->dbcon, $sql);
		$vrst = mysqli_fetch_assoc($result);
		$idUp = $vrst["id"];
		mysqli_free_result($result);
		*/
		$idUp = $current;
		
		// preverjanje, če je v tabeli blokade pravilen vnos
		$sql = "SELECT * FROM blokade WHERE id_uporabnik=$idUp AND id_blokiran=$idBlok;";
		$result = mysqli_query($this->dbcon, $sql);
		$row = mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result) == 0){
			// ni blokiran
			return false;
		} else {
			// je blokiran
			return true;
		}
	}
	
	// GET metode
    function getDbcon(){
        return $this->dbcon;
    }
    
    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }
    
	// SET METODE
    function setDbcon($dbcon){
        $this->dbcon=$dbcon;
    }
    
    function setId($id){
        $this->id=$id;
    }
    
    function setUsername($username){
        $this->username=$username;
    }
    
    function setPassword($password){
        $this->password=$password;
    }
}