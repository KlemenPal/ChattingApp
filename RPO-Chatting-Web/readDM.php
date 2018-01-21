<?php
// baza
session_start();
$servername = "164.8.251.204";
$database = "student119";
$username = "student119";
$password = "mysql";

// preverjanje
if(!isset($_SESSION['DMchat'])){
	echo "<p>Napaka! Prijatelj, kateremu hočeš pisati, ne obstaja!</p>";
	exit;
}

//connect to db
$db = mysqli_connect($servername, $username, $password, $database);

// <img height=\"20\" width=\"20\" src=\"\" title=\"\">

// polji za emoji-je
$znaki = array(":smile:",":heart:",/*":brheart:",":peace:",*/":sad:",":mad:",/*":angel:",*/":cool:",":100:",":thup:",":thdown:");
$emoji = array(	"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/Smiling_Emoji_with_Eyes_Opened_large.png\" title=\":smile:\">",
				"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/Heart_Eyes_Emoji_large.png\" title=\":heart:\">",
				//"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/Broken_Red_Heart_Emoji_large.png\" title=\":brheart:\">",
				//"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/Victory_Hand_Emoji_large.png\" title=\":peace:\">",
				"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/Sad_Face_Emoji_large.png\" title=\":sad:\">",
				"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/Very_Angry_Emoji_7f7bb8df-d9dc-4cda-b79f-5453e764d4ea_large.png\" title=\":mad:\">",
				//"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/Smiling_Face_with_Halo_large.png\" title=\":angel:\">",
				"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/Sunglasses_Emoji_be26cc0a-eef9-49e5-8da2-169bb417cc0b_large.png\" title=\":cool:\">",
				"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/100_Emoji_large.png\" title=\":100:\">",
				"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/Thumbs_Up_Hand_Sign_Emoji_large.png\" title=\":thup:\">",
				"<img height=\"20\" width=\"20\" src=\"https://cdn.shopify.com/s/files/1/1061/1924/products/White_Thumbs_Down_Sign_Emoji_large.png\" title=\":thdown:\">"
				);

// nalaganje drugega uporabnika (id)
$s = $_SESSION['DMchat'];

$r = mysqli_query($db, "SELECT id FROM uporabniki WHERE username='$s';");

if(mysqli_num_rows($r) > 0){
	$row = mysqli_fetch_assoc($r);
	$idOn = $row["id"];
} else {
	echo "<p>Napaka! Prijatelj, kateremu hočeš pisati, ne obstaja!</p>";
	mysqli_close($db);
	exit;
}
mysqli_free_result($r);

// nalaganje trenutnega uporabnnika iz seje (id)
$currentUserID = $_SESSION['user'];
$r = mysqli_query($db, "SELECT id FROM uporabniki WHERE username='$currentUserID';");

if(mysqli_num_rows($r) > 0){
	$row = mysqli_fetch_assoc($r);
	$idJaz = $row["id"];
} else {
	echo "<p>Napaka! </p>";
	exit;
}
mysqli_free_result($r);

$sql = "SELECT * FROM dmchat;";
$result = mysqli_query($db, $sql);

include_once 'dbcontrollers/Uporabnik.php';

// vse informacije o uporabniku (preprečevanje gnezdenja SQL stavkov)
$allUserInfo = mysqli_query($db, "SELECT * FROM uporabniki;");
// informacije o blokiranih uporabnikih
$allBlocks = mysqli_query($db, "SELECT * FROM blokade;");

if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		// spremeni ker ne dela
		// variable slikaUp in uName naredi...
		$msgID = $row["id"];
		date_default_timezone_set('Europe/Ljubljana');
		$text = $row["message"];
		$user_id = $row["id_posiljatelj"];
		
		/*
		$sql = "SELECT * FROM uporabniki WHERE id=$user_id;";
		$res = mysqli_query($db, $sql);
		if (mysqli_num_rows($res) == 1) { // če je 1 rezultat
			while ($row_2 = mysqli_fetch_assoc($res)) {
				$uName = $row_2['username'];
				$slikaup = $row_2["slika"];
				$email = $row_2["email"];
			}
		}
		mysqli_free_result($res);
		*/
		while($row_2 = mysqli_fetch_assoc($allUserInfo)){
			$uName = $row_2['username'];
			$slikaup = $row_2['slika'];
			$email = $row_2['email'];
			// breaknemo če smo našli pravega userja
			if($user_id == $row_2['id']){
				break;
			}
		}
		mysqli_data_seek($allUserInfo, 0); // reset result to start
		
		
		// blokade...
		$jazNjega = 0;
		$onMene = 0;
		while($vrst = mysqli_fetch_assoc($allBlocks)){
			if($vrst['id_uporabnik'] == $idJaz && $vrst['id_blokiran'] == $user_id){
				// jaz sem njega blokiral
				$jazNjega = 1;
				break;
			}
			if($vrst['id_uporabnik'] == $user_id && $vrst['id_blokiran'] == $idJaz){
				$onMene = 1;
			}
		}
		mysqli_data_seek($allBlocks, 0);
		
		$timestamp = strtotime($row["time"]); // timestamp za datum + ure
        //$time = date('G:i', strtotime($row["time"])); // H:Min
		$date = date('d-m-Y', $timestamp);
		$time = date('G:i', $timestamp);
		$text = nl2br(htmlspecialchars($text));
		
		// URL regexp + polja za text 
		$regExp = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		$urlji = array();
		$urlsToReplace = array();
		// iskanje vseh URL-jev
		if(preg_match_all($regExp, $text, $urlji)) {
			// prešteje URL-je
			$stUrljev = count($urlji[0]);
			$stZaZamenjavo = 0;
			for($i=0; $i<$stUrljev; $i++) {
				$zeDodan = false;
				$stZaZamenjavo = count($urlsToReplace);
				for($j=0; $j<$stZaZamenjavo; $j++) {
					if($urlsToReplace[$j] == $urlji[0][$i]) {
						$zeDodan = true;
					}
				}
				if(!$zeDodan) {
					array_push($urlsToReplace, $urlji[0][$i]);
				}
			}
			// zamenjava URL-jev
			$stZaZamenjavo = count($urlsToReplace);
			for($i=0; $i<$stZaZamenjavo; $i++) {
				// preverjanje za valid URL
				if (filter_var($urlsToReplace[$i], FILTER_VALIDATE_URL)) {
					if (@GetImageSize($urlsToReplace[$i])) {
						// slika
						$text = str_replace($urlsToReplace[$i], "<a target=\"_blank\" href=\"".$urlsToReplace[$i]."\"><img src=\"$urlsToReplace[$i]\" width=\"100%\" 
						height=\"100%\" style=\"object-fit: scale-down;\"></a> ", $text);
					} else {
						// url
						$text = str_replace($urlsToReplace[$i], "<a target=\"_blank\" href=\"".$urlsToReplace[$i]."\">".$urlsToReplace[$i]."</a> ", $text);
					}
				} else {}
			}
		}
		//
		
		// emoji-ji
		$text = str_replace($znaki,$emoji,$text);
		
		// preverjanje, če je uporabnik blokiran... (popravi zaradi overload-a)
		/*
		$upor = new Uporabnik();
		if($upor->JeBlokiran($idJaz, $user_id) == true){
			echo "<div class=\"sporocilo drugi\">
						<div class=\"slikaUp\"><a href=\"$slikaup\" target=\"_blank\" title=\"$email\"><img src=\"$slikaup\" alt=\"noImg\"></a></div>
						<p class=\"msgUp\"></b> Uporabnik <em style=\"color:lightgrey\">$uName</em> je blokiran!!! <br><br>
						<button class=\"chatButtons\" onclick=\"blokirajUporabnika($user_id)\">Odblokiraj</button></p>
					</div>";
			continue;
		}
		if($upor->JeBlokiran($user_id, $idJaz) == true){
			echo "<div class=\"sporocilo drugi\">
						<div class=\"slikaUp\"><a href=\"$slikaup\" target=\"_blank\" title=\"$email\"><img src=\"$slikaup\" alt=\"noImg\"></a></div>
						<p class=\"msgUp\"></b> Uporabnik <em style=\"color:lightgrey\">$uName</em> te je blokiral!!! <br><br>
					</div>";
			continue;
		}
		*/
		if($jazNjega == 1){
			echo "<div class=\"sporocilo drugi\">
						<div class=\"slikaUp\"><a href=\"$slikaup\" target=\"_blank\" title=\"$email\"><img src=\"$slikaup\" alt=\"noImg\"></a></div>
						<p class=\"msgUp\"></b> Uporabnik <em style=\"color:lightgrey\">$uName</em> je blokiran!!! <br><br>
						<button class=\"chatButtons\" onclick=\"blokirajUporabnika($user_id)\">Odblokiraj</button></p>
					</div>";
			continue;
		}
		if($onMene == 1){
			echo "<div class=\"sporocilo drugi\">
						<div class=\"slikaUp\"><a href=\"$slikaup\" target=\"_blank\" title=\"$email\"><img src=\"$slikaup\" alt=\"noImg\"></a></div>
						<p class=\"msgUp\"></b> Uporabnik <em style=\"color:lightgrey\">$uName</em> te je blokiral!!! <br><br>
					</div>";
			continue;
		}
		
		if($row["id_posiljatelj"] == $idJaz && $row["id_prejemnik"] == $idOn){ // jaz sem bil tisti, ki je poslal sporočilo
			// echo "<p><b><em style=\"color:red\">[$date, $time]</em>  <em style=\"color:#7415F0\">Me</em></b><br>$text</p>";
			echo "<div class=\"sporocilo jaz\">
						<div class=\"slikaUp\"><a href=\"$slikaup\" target=\"_blank\" title=\"$email\"><img src=\"$slikaup\" alt=\"noImg\"></a></div>
						<p class=\"msgUp\"><b><em style=\"color:lightgrey\">[$date, $time]: $uName</em></b><br>$text <br><br>
						<button class=\"chatButtons\" onclick=\"izbrisSporocilaDM($msgID)\">Izbriši</button></p>
					</div>";
		}
		if($row["id_posiljatelj"] == $idOn && $row["id_prejemnik"] == $idJaz){ // on mi je poslal sporočilo
			echo "<div class=\"sporocilo drugi\">
						<div class=\"slikaUp\"><a href=\"$slikaup\" target=\"_blank\" title=\"$email\"><img src=\"$slikaup\" alt=\"noImg\"></a></div>
						<p class=\"msgUp\"><b><em style=\"color:lightgrey\">[$date, $time]: $uName</em></b><br>$text <br><br>
						<button class=\"chatButtons\" onclick=\"blokirajUporabnika($idOn)\">Blokiraj</button></p>
					</div>";
		}
	}
	// echo "<p>ID SOBE: $idS</p>"; // testiranje
}

mysqli_free_result($result);
mysqli_free_result($allUserInfo);

mysqli_close($db);

?>
