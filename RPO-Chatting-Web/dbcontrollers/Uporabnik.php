<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Uporabnik
 *
 * @author pal.klemen
 */
class Uporabnik {
    
    private $id;
    private $username;
    private $password;
    private $dbcon;
	
	// kreiranje povezave
    public function __construct() {
		$servername = "sql11.freemysqlhosting.net";
		$database = "sql11201543";
		$username = "sql11201543";
		$password = "RNWDUNINqK";
		/*
		$servername = "sql11.freesqldatabase.com";
		$database = "sql11201575";
		$username = "sql11201575";
		$password = "fzx7heiw3p";
		*/

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
		$sql = "SELECT * FROM uporabnik WHERE username='$user' and password='$pass'; ";
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
        $sql = "INSERT INTO uporabnik (username,password) VALUES "
                . "('$user','$geslo');";
        $result = mysqli_query($this->dbcon,$sql);
        if(!$result) {
            echo "Napaka v povpraševanju.\n";
            exit;
        }
        else {
            ?><!--<p align="center">Registracija uspešna.</p>--><?php
        }
    }
    
	public function PreveriUsername($user){
		$sql = "SELECT * FROM uporabnik WHERE username='$user';";
        $result = mysqli_query($this->dbcon,$sql);
        if(!$result) {
            echo "Napaka v povpraševanju.\n";
            exit;
        }
        return $result;
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