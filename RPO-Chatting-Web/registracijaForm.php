<?php
?>

<html>
    <head>
        <meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/forms.css">
		<style>
			body { overflow-y:scroll; }
		</style>
    </head>
    <body>
		<div class="forma">
		<form class="obrazec" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onsubmit="return checkAll()">
			<header>Register</header>
			<p>Username:</p> <input type="text" pattern=".{3,}" required title="Minium 3 chars!" placeholder="Type Username" name="user" onkeyup="validateUsername()" id="nm">
			<br>
			<p>Password:</p> <input type="password" pattern=".{3,}" required title="Minium 3 chars!" placeholder="Type Password" name="pass" onkeyup="validatePass()" id="pw">
			<br>
			<p>Retype Password:</p> <input type="password" pattern=".{3,}" required title="Minium 3 chars!" placeholder="Retype Password" name="repPass" onkeyup="validatePass()" id="rpw">
			<br>
			<input type="submit" value="Register" name="submit">
		</form>
		</div>
		<p align="center"><a href="login.php">Login</a></p>
		<script>
			// function
			function validateUsername(){
				// pridobitev vrednosti
				var uname = document.getElementById("nm").value;
				
				// preverjanje dolžine
				if(uname.length < 3){
					document.getElementById("nm").style.backgroundColor = "#FF3333";
					return;
				}
				if(uname.length > 50){
					document.getElementById("nm").style.backgroundColor = "#FF3333";
					return;
				}
				
				// regularni izraz za preverjanje če so le črke in številke
				var reg = /^[a-zA-Z0-9_ ]*$/;
				if(uname.match(reg)){
					document.getElementById("nm").style.backgroundColor = "#66FF66";
				} else {
					document.getElementById("nm").style.backgroundColor = "#FF3333";
				}
			}
			
			// sprotno preverjanje gesla ob vnašanju podatkov uporabnika
			function validatePass(){
				// pridobitev vrednosti
				var pass = document.getElementById("pw").value;
				var repPass = document.getElementById("rpw").value;
				
				// če je dolžina manj od 3 ne gre vnesti v bazo
				if(pass.length < 3 || repPass.length < 3){
					document.getElementById("pw").style.backgroundColor = "#FF3333";
					document.getElementById("rpw").style.backgroundColor = "#FF3333";
					return;
				}
				
				// če je dolžina več od 50 tudi ne gre vnesti v bazo
				if(pass.length > 50 || repPass.length > 50){
					document.getElementById("pw").style.backgroundColor = "#FF3333";
					document.getElementById("rpw").style.backgroundColor = "#FF3333";
					return;
				}
				
				// regularni izraz za preverjanje če so le črke in številke
				var reg = /^[a-zA-Z0-9_ ]*$/;
				if(pass.match(reg) && repPass.match(reg)){
					// OK
				} else {
					document.getElementById("pw").style.backgroundColor = "#FF3333";
					document.getElementById("rpw").style.backgroundColor = "#FF3333";
					return;
				}
				
				// primerjava gesel (če sta enaka = zelen background, če ne pa rdeč)
				if(pass == repPass){
					document.getElementById("pw").style.backgroundColor = "#66FF66";
					document.getElementById("rpw").style.backgroundColor = "#66FF66";
					return;
				} else {
					document.getElementById("pw").style.backgroundColor = "#FF3333";
					document.getElementById("rpw").style.backgroundColor = "#FF3333";
					return;
				}
			}
			
			// preverjanje gesel pred submitom
			function checkAll(){
				// pridobitev vrednosti
				var uname = document.getElementById("nm").value;
				var pass = document.getElementById("pw").value;
				var repPass = document.getElementById("rpw").value;
				
				// preverjanje dolžin
				if(pass.length < 3 || repPass.length < 3 || uname.length < 3 || pass.length > 50 || repPass.length > 50 || uname.length > 50){
					return false;
				}
				
				// regularni izraz za le številke in črke
				var reg = /^[a-zA-Z0-9_ ]*$/;
				if(uname.match(reg) && pass.match(reg) && repPass.match(reg)){
					if(pass == repPass){
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
		</script>
    </body>
</html>