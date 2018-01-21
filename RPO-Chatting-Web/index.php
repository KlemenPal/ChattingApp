<?php
session_start(); // začne novo sejo ali nadaljuje s prejšnjo

//echo "This a first / test page for a Chatting Website. <br>";
//echo "This page is used for redirections.";
if(!isset($_SESSION['user'])){ // seje za uporabnika ni - ni se vpisal
	// izpis napake in preusmeritev na stran za login in registracijo
	// skripta za "alert" o preusmeritvi
	echo '<script language="javascript">';
	echo 'alert("Login expired, you will be redirected.")';
	echo '</script>';
    header("Location: login.php");
	exit;
} 

if (isset($_GET['addToRoom']) && isset($_SESSION['DMchat']) && isset($_SESSION['chat'])){
    // dodaj v sobo
	include_once 'dbcontrollers/Soba.php';
	include_once 'dbcontrollers/Uporabnik.php';
	$tempUser = new Uporabnik();
	$idUserja = $tempUser->PretvoriImeID($_SESSION['DMchat']);
	$room = new Soba();
	$room->AddToRoom($idUserja, $_SESSION['chat']);
	header("Location: index.php");
}
if (isset($_GET['deleteUser']) && isset($_SESSION['user'])){
	// baza
	$servername = "164.8.251.204";
	$database = "student119";
	$username = "student119";
	$password = "mysql";

	//connect to db
	$db = mysqli_connect($servername, $username, $password, $database);

	// uporabnik class
	include_once 'dbcontrollers/Uporabnik.php';
	$u = new Uporabnik();
	$jaz = $_SESSION['user'];
	$r = $u->PreveriUsername($jaz);

	// če je uporabnik v bazi
	if(mysqli_num_rows($r) == 0){
		echo "User $jaz doesn't exist!";
		mysqli_close($db);
		return;
	}

	// če si na index.php
	mysqli_query($db, "DELETE FROM uporabniki WHERE username='$jaz';");
	mysqli_close($db);

	session_destroy();
	header("Location: login.php");
}


/*
else {	// uporabnik se je uspešno vpisal
	echo "<br><br><br>Login Successful, welcome " . $_SESSION['user'] . ".<br>
			<a href=\"logout.php\">LOG OUT</a>";
}


				<select onchange="vnosEmoji()" id="vnosEmoji"></select>

*/


?>
<html>
	<head>
		<!-- Metapodatki -->
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>CHAT</title>
		<!-- Vključitev oblikovanja -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Amaranth" />
		<!-- mikrofon -->
		<link rel="stylesheet" type="text/css" href="css/microphone.css" />
	</head>
	<body>
		<!-- Glava na spletni strani -->
		<div class="head">
			<div class="head_user">
				<a><p class="smallCaps" style="margin-top: 5px;"><?php echo $_SESSION['user']?></p></a>
				<a onclick="delUser()"><img src="images/delete.svg" title="Delete User" alt="Delete User"></a>
			</div>
			<div class="head_opt">
				<a><input placeholder="Room Name" id="addRoom" type="text" style="line-height: 40px;"></a>
				<a onclick="addRoom()"><img src="images/add.svg" title="Add Room" alt="Add Room"></a>
				<a style="margin-left: 100px;"><input placeholder="Friends Username" id="searchUser" type="text" style="line-height: 40px;"></a>
				<a onclick="addFriend()"><img src="images/add.svg" title="Add Friend" alt="Add Friend"></a>
				<a href="index.php"><img src="images/home.svg" title="Home" alt="Home"/></a>
				<a href="usersettings.php"><img class="rotationImg" src="images/settings.svg" title="Settings" alt="Settings"/></a>
				<a href="logout.php"><img src="images/logout.svg" title="Logout" alt="Logout"/></a>
			</div>
		</div>
	
		<!-- Main Chat -->
		<div class="core_public">
			<div>
				<!--<h1 align="center" style="color: #DCDCDC;" class="smallCaps">Chat Logs</h1>-->
				<div class="chat">
					<div id="chatOutput">
					
						<!-- TESTIRANJE -->
						<!--
						<div class="sporocilo drugi">
							<div class="slikaUp"><img src="https://orig00.deviantart.net/c77d/f/2014/314/9/6/fire_and_ice___yin_yang_by_13crazygir-d860udn.png" alt="noImg"></div>
							<p class="msgUp">Dober dan, kako ste kaj danes.</p>
						</div>
						<div class="sporocilo jaz">
							<div class="slikaUp"><img src="http://i.dailymail.co.uk/i/pix/2017/01/16/20/332EE38400000578-4125738-image-a-132_1484600112489.jpg" alt="noImg"></div>
							<p class="msgUp">Jaz sem vredu, kaj pa ti.</p>
						</div>
						<div class="sporocilo drugi">
							<div class="slikaUp"><img src="https://orig00.deviantart.net/c77d/f/2014/314/9/6/fire_and_ice___yin_yang_by_13crazygir-d860udn.png" alt="noImg"></div>
							<p class="msgUp">
							Imam vprašanje, ali to deluje tako kot treba za več vrstic? ... <br> 
							Mislim da ja ampak nisem prepričan... <br>
							Če ja potem ok.
							</p>
						</div>
						-->
						<!-- TESTIRANJE -->
						
					</div>
					<textarea id="chatInput" class="speech-input" type="text" placeholder="Text..." maxlength="250"></textarea>
					<button id="chatSend" onclick="sendChatClicked()">SEND</button>
				</div>
				<!-- <p>Logged in as: <b><?php echo $_SESSION['user'] ?></b> <a href="settings.php">(Settings)</a>.</p> -->
			</div>
			
			<!-- EMOJI -->
			<div align="center" style="margin-top:10px">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Smiling_Emoji_with_Eyes_Opened_large.png" title=":smile:" onclick="chatEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Sad_Face_Emoji_large.png" title=":sad:" onclick="chatEmoji(this)">
				<!--<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Smiling_Face_with_Halo_large.png" title=":angel:" onclick="chatEmoji(this)">-->
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Very_Angry_Emoji_7f7bb8df-d9dc-4cda-b79f-5453e764d4ea_large.png" title=":mad:" onclick="chatEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Sunglasses_Emoji_be26cc0a-eef9-49e5-8da2-169bb417cc0b_large.png" title=":cool:" onclick="chatEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Heart_Eyes_Emoji_large.png" title=":heart:" onclick="chatEmoji(this)">
				<!--<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Broken_Red_Heart_Emoji_large.png" title=":brheart:" onclick="chatEmoji(this)">-->
				<!--<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Victory_Hand_Emoji_large.png" title=":peace:" onclick="chatEmoji(this)">-->
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Thumbs_Up_Hand_Sign_Emoji_large.png" title=":thup:" onclick="chatEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/White_Thumbs_Down_Sign_Emoji_large.png" title=":thdown:" onclick="chatEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/100_Emoji_large.png" title=":100:" onclick="chatEmoji(this)">
			</div>
			
			<h1 align="center" style="color: #DCDCDC;" class="smallCaps">Room <?php if(isset($_SESSION['chat'])){echo $_SESSION['chat'];} ?></h1>
			<div align="center">
				<!-- Branje sob iz baze -->
				<select onchange="spremembaSobe()" id="izbiraSobe">
					<option value="" disabled selected style="display:none;">Rooms</option>
				<?php
					include_once 'dbcontrollers/Uporabnik.php';
					include_once 'dbcontrollers/Soba.php';
					$soba = new Soba();
					$u = new Uporabnik();
					$curUID = $u->PretvoriImeID($_SESSION['user']);
					// $soba->SeznamSob(); // vse sobe...
					$soba->SeznamMojihSob($curUID);
					// testiranje
					// echo "<option>1</option><option>to</option><option>je</option><option>testiranje.</option>";
				?>
				</select>
				<!-- NE DELA S SLIKAMI
				<select onchange="chatEmoji()" id="chatEmoji">
					<option value="" disabled selected style ="display:none;">Emoji</option> 
					<option value="NoEmoji">NoEmoji</option>
					<option value=":smile:"></option>
					<option value=":sad:">:sad:</option>
					<option value=":cool:">:cool:</option>
					<option value=":mad:">:mad:</option>
					<option value=":angel:">:angel:</option>
					<option value=":heart:">:heart:</option>
					<option value=":brheart:">:brheart:</option>
					<option value=":peace:">:peace:</option>
					<option value=":thup:">:thdup:</option>
					<option value=":thdown:">:thup:</option>
					<option value=":100:">:100:</option>
				</select>
				-->
			</div>
			<!-- Izbris (pred tem še preverjaj, če je user admin...) -->
			<?php 
				if(isset($_SESSION['chat'])){
					if($u->PreveriAdminVSobi($_SESSION['user'], $soba->nameToID($_SESSION['chat'])) == 2){
						// gumb je viden...
						?>		
						<div align="center" style="margin-top: 10px;">
							<button onclick="deleteRoom('<?php echo $_SESSION['chat']; ?>')" class="izbrisStyle">Delete Room</button>
						</div>
						<?php
					}
				}
			?>
			<div align="center" style="margin-top: 10px;">
				<a href='index.php?addToRoom=true'>Add Selected Friend To Room</a>
			</div>
		</div>
		
		<!-- Private Chat -->
		<div class="core_private">
			<div>
				<!--<h1 align="center" style="color: #DCDCDC;" class="smallCaps">DM Logs</h1>-->
				<div class="chat">
					<div id="DMOutput"></div>
					<textarea id="DMInput" class="speech-input" type="text" placeholder="Text..." maxlength="250"></textarea>
					<button id="DMSend" onclick="sendDMClicked()">SEND</button>
				</div>
				<!-- <p>Logged in as: <b><?php echo $_SESSION['user'] ?></b> <a href="settings.php">(Settings)</a>.</p> -->
			</div>
			
			<!-- EMOJI -->
			<div align="center" style="margin-top:10px">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Smiling_Emoji_with_Eyes_Opened_large.png" title=":smile:" onclick="dmEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Sad_Face_Emoji_large.png" title=":sad:" onclick="dmEmoji(this)">
				<!--<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Smiling_Face_with_Halo_large.png" title=":angel:" onclick="dmEmoji(this)">-->
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Very_Angry_Emoji_7f7bb8df-d9dc-4cda-b79f-5453e764d4ea_large.png" title=":mad:" onclick="dmEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Sunglasses_Emoji_be26cc0a-eef9-49e5-8da2-169bb417cc0b_large.png" title=":cool:" onclick="dmEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Heart_Eyes_Emoji_large.png" title=":heart:" onclick="dmEmoji(this)">
				<!--<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Broken_Red_Heart_Emoji_large.png" title=":brheart:" onclick="dmEmoji(this)">-->
				<!--<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Victory_Hand_Emoji_large.png" title=":peace:" onclick="dmEmoji(this)">-->
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/Thumbs_Up_Hand_Sign_Emoji_large.png" title=":thup:" onclick="dmEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/White_Thumbs_Down_Sign_Emoji_large.png" title=":thdown:" onclick="dmEmoji(this)">
				<img height="30" width="30" src="https://cdn.shopify.com/s/files/1/1061/1924/products/100_Emoji_large.png" title=":100:" onclick="dmEmoji(this)">
			</div>
			
			<h1 align="center" style="color: #DCDCDC;" class="smallCaps">Friends</h1>
			<div align="center">
				<!-- Branje sob iz baze -->
				<select onchange="spremembaDM()" id="izbiraUporabnika">
					<option value="" disabled selected style="display:none;">Friends</option>
				<?php
					$u = new Uporabnik();
					// $u->SeznamUporabnikov();
					$u->SeznamPrijateljev();
					// testiranje
					// echo "<option>1</option><option>to</option><option>je</option><option>testiranje.</option>";
				?>
				</select>
				<!-- NE DELA S SLIKAMI
				<select onchange="dmEmoji()" id="dmEmoji">
					<option value="" disabled selected style ="display:none;">Emoji</option>
					<option value="NoEmoji">NoEmoji</option>
					<option value=":smile:">:smile:</option>
					<option value=":sad:">:sad:</option>
					<option value=":cool:">:cool:</option>
					<option value=":mad:">:mad:</option>
					<option value=":angel:">:angel:</option>
					<option value=":heart:">:heart:</option>
					<option value=":brheart:">:brheart:</option>
					<option value=":peace:">:peace:</option>
					<option value=":thup:">:thdup:</option>
					<option value=":thdown:">:thup:</option>
					<option value=":100:">:100:</option>
				</select>
				-->
			</div>
			<!-- Izbris -->
			<div align="center" style="margin-top: 10px;">
				<button onclick="removeFriend()" class="izbrisStyle">Remove Friend</button>
			</div>
		</div>


		<!-- Vključitev skript -->

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="js/chat.js"></script>
		<!-- mikrofon -->
		<script src="js/speech-input.js"></script>
	</body>
</html>