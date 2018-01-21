<?php
?>
<html>
	<head>
		<!-- Metapodatki -->
		<meta charset="UTF-8" />
		<title>CHAT</title>
		<!-- Vključitev oblikovanja -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/forms.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Amaranth" />
		<!--
		<style>
			.head {
				overflow: hidden;
				background-color: #333;
				position: fixed;
				top: 0;
				width: 100%;
				display: flex; 
				justify-content: space-between;
			}
			.head a {
				float: left;
				display: block;
				color: #f2f2f2;
				text-align: center;
				padding: 14px 16px;
				text-decoration: none;
				font-size: 17px;
			}
		</style>
		-->
		<style>
			body {overflow-y: scroll;}
		</style>
	</head>
	<body>
		<div class="head">
			<div class="head_user">
				<a><p class="smallCaps" style="margin-top: 5px;"><?php echo $_SESSION['user']?></p></a>
			</div>
			<div class="head_opt">
				<a href="index.php"><img src="images/home.svg" title="Home" alt="Home"/></a>
				<a href="usersettings.php"><img class="rotationImg" src="images/settings.svg" title="Settings" alt="Settings"/></a>
				<a href="logout.php"><img src="images/logout.svg" title="Logout" alt="Logout"/></a>
			</div>
		</div>
		<div class="forma" style="width: 90%">
			<form class="obrazec" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onsubmit="return checkAll()">
				<header>Options</header>
				<p>Username:</p> <input type="text" pattern=".{3,}" required title="Minium 3 chars!" placeholder="Type Username" name="user" onkeyup="validateUsername()" id="nm">
				<p>Password:</p> <input type="password" pattern=".{3,}" required title="Minium 3 chars!" placeholder="Type Password" name="pass" onkeyup="validatePass()" id="pw">
				<p>Retype Password:</p> <input type="password" pattern=".{3,}" required title="Minium 3 chars!" placeholder="Type Password" name="pass2" onkeyup="validatePass()" id="rpw">
				<p>Email:</p> <input type="email" placeholder="Type E-Mail" name="mail" onkeyup="validateMail()" id="mail">
				<p>Image:</p> <input type="text" placeholder="Paste Image Link" name="image" id="im">
				<input type="submit" value="Change" name="submit">
			</form>
		</div>
		<script>
			// username preverba
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
			
			// preverjanje slike in maila
			function validateMail(){
				// pridobitev vrednosti
				var mail = document.getElementById("mail").value;
				
				// pač ni podanega maila
				if(mail.length == 0){
					document.getElementById("mail").style.backgroundColor = "#66FF66";
					return;
				}
				
				// predolg mail
				if(mail.length > 100){
					document.getElementById("mail").style.backgroundColor = "#FF3333";
					return;
				}
				
				// preverjanje če je regularni izraz podoben mailu
				var mailreg = /(\w(=?@)\w+\.{1}[a-zA-Z]{2,})/i;
				if(mail.match(mailreg)){
					document.getElementById("mail").style.backgroundColor = "#66FF66";
					return;
				} else {
					document.getElementById("mail").style.backgroundColor = "#FF3333";
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
				
				// preverjanje maila in slike
				var mail = document.getElementById("mail").value;
				var im = document.getElementById("im").value;
				if(mail.length > 100 || im.length > 10000){
					alert("Predolg niz pri sliki ali mailu.");
					return false;
				}
				
				// regularni izraz za le številke in črke
				var reg = /^[a-zA-Z0-9_ ]*$/;
				var mailreg = /(\w(=?@)\w+\.{1}[a-zA-Z]{2,})/i;
				if(uname.match(reg) && pass.match(reg) && repPass.match(reg) && mail.match(mailreg)){
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
		<!--<p align="center">After the changes, you will have to Login again.</p>-->
    </body>
</html>