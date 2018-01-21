<?php

class Soba {
    
    private $id;
    private $name;
	
	// kreiranje povezave
    public function __construct() {
		/*
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
	
	// VSE sobe
	public function SeznamSob(){
		$sql = "SELECT * FROM sobe;";
		$result = mysqli_query($this->dbcon, $sql);
		// izpis sob v seznam opcij (select)
		
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$soba = htmlspecialchars($row["name"]);
				echo "<option value=\"$soba\">$soba</option>";
			}
			mysqli_free_result($result);
			return true;
		}
		
		mysqli_free_result($result);
		return false;
	}
	
	// MOJE sobe (v katere si dodan)
	public function SeznamMojihSob($curUID){
		$sql = "SELECT * FROM user_v_sobi WHERE id_uporabnik=$curUID;";
		$result = mysqli_query($this->dbcon, $sql);
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)){
				$curRID = $row['id_sobe'];
				$res = mysqli_query($this->dbcon, "SELECT * FROM sobe WHERE id=$curRID;");
				$vrst = mysqli_fetch_assoc($res);
				$soba = $vrst['name'];
				echo "<option value=\"$soba\">$soba</option>";
				mysqli_free_result($res);
			}
		}
		mysqli_free_result($result);
	}
	
	// ime -> id sobe
	public function nameToID($name){
		$sql = "SELECT * FROM sobe WHERE name='$name';";
		$res = mysqli_query($this->dbcon, $sql);
		if(mysqli_num_rows($res) == 1){
			$vrst = mysqli_fetch_assoc($res);
			$id = $vrst["id"];
			return $id;
		}
	}
	
	// dodajanje uporabnika v sobo
	
	public function AddToRoom($curUID, $room){
		// pridobivanje ID-ja sobe
		$sql = "SELECT * FROM sobe WHERE name='$room';";
		$res = mysqli_query($this->dbcon, $sql);
		if(mysqli_num_rows($res) != 0){
			$vrst = mysqli_fetch_assoc($res);
			$curRID = $vrst['id'];
		} else {
			return;
		}
		
		mysqli_free_result($res);
		// preverjanje ce je user že v sobi, če ni ga doda
		$sql = "SELECT * FROM user_v_sobi WHERE id_uporabnik=$curUID AND id_sobe=$curRID;";
		$res = mysqli_query($this->dbcon, $sql);
		if(mysqli_num_rows($res) == 0){
			mysqli_query($this->dbcon, "INSERT INTO user_v_sobi (id_uporabnik, id_sobe) VALUES ($curUID, $curRID);");
		}
		mysqli_free_result($res);
	}
	
	
	// GET metode
    function getDbcon(){
        return $this->dbcon;
    }
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->username;
    }
    
	// SET METODE
    function setDbcon($dbcon){
        $this->dbcon=$dbcon;
    }
    
    function setId($id){
        $this->id=$id;
    }
    
    function setName($username){
        $this->username=$username;
    }
}