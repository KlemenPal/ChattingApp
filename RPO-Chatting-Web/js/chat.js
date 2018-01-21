// GLAVNI CHAT
var chatInterval = 3000; // interval, v katerem se bo chat osvežil (ms)
var $chatOutput = $("#chatOutput"); // izpis chat-a
document.getElementById("chatOutput").scrollTop = document.getElementById("chatOutput").scrollHeight;
// pošiljanje sporočil
function sendMessageChat() {
	// var userNameString = $userName.val();
	var chatInputString = document.getElementById("chatInput").value; // pridobivanje vnosa iz polja
	
	// preverjanje za prazen vnos in t.i. whitespace
	if(chatInputString == null || chatInputString == ""){
		alert("Wrong input (empty string OR whitespace).");
		return;
	}
	if(chatInputString.length > 250){
		alert("Input too long, max 250 characters.");
		return;
	}
	if ( $.trim( $('#chatInput').val() ) == '' ){
		alert("Wrong input (empty string OR whitespace).");
		return;
	}
		
	// kličemo write.php, ki zapiše chat v bazo (če je bil OK vnos)
	$.get("write.php", {
		text: chatInputString
	});
	
	// clearanje polja
	document.getElementById("chatInput").value="";
	
	retrieveMessages(); // po koncu vedno osveži
}
// interval za osveževanje chat-a, sinhronizacija vsakih nekaj ms (treuntno 300)
setInterval(retrieveMessagesChat, chatInterval);


// prejemanje sporočil
var naDnu = true;
// TEST
jQuery(function($) {
    $('#chatOutput').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            naDnu = true;
        } else {
			naDnu = false;
		}
    })
});

function retrieveMessagesChat() {
	$.get("read.php", function (data) {
		$chatOutput.html(data); // izpiše chat
	});
	if(naDnu == true){
		var chat = document.getElementById("chatOutput");
		chat.scrollTop = chat.scrollHeight;
	}
}


// pošiljanje sporočil	
function sendChatClicked(){
	sendMessageChat();
}
// sprememba sobe
function spremembaSobe(){
	var opcija = document.getElementById("izbiraSobe").value;
	// alert(opcija);
	$.get("roomchange.php", {
		text: opcija
	});
	location.reload(true);
}
// emoji-ji
function chatEmoji(obj){
	document.getElementById("chatInput").value = document.getElementById("chatInput").value + obj.title;
}






// DM CHAT
var $DMOutput = $("#DMOutput"); // izpis chat-a
document.getElementById("DMOutput").scrollTop = document.getElementById("DMOutput").scrollHeight;
// pošiljanje sporočil
function sendDMChat() {
	// var userNameString = $userName.val();
	var DMInputString = document.getElementById("DMInput").value; // pridobivanje vnosa iz polja
	
	// preverjanje za prazen vnos in t.i. whitespace
	if(DMInputString == null || DMInputString == ""){
		alert("Wrong input (empty string OR whitespace).");
		return;
	}
	if(DMInputString.length > 250){
		alert("Input too long, max 250 characters.");
	}
	if ( $.trim( $('#DMInput').val() ) == '' ){
		alert("Wrong input (empty string OR whitespace).");
		return;
	}
		
	// kličemo writeDM.php, ki zapiše DM v bazo (če je bil OK vnos)
	$.get("writeDM.php", {
		text: DMInputString
	});
	
	// clearanje polja
	document.getElementById("DMInput").value="";
	
	retrieveMessagesDM(); // po koncu vedno osveži
}
// interval za osveževanje chat-a, sinhronizacija vsakih nekaj ms (treuntno 300)
setInterval(retrieveMessagesDM, chatInterval);


// prejemanje sporočil
var DMdno = true;
// TEST
jQuery(function($) {
    $('#DMOutput').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            DMdno = true;
        } else {
			DMdno = false;
		}
    })
});
function retrieveMessagesDM() {
	$.get("readDM.php", function (data) {
		$DMOutput.html(data); // izpiše chat
	});
	if(DMdno == true){
		var chat = document.getElementById("DMOutput");
		chat.scrollTop = chat.scrollHeight;
	}
}


// pošiljanje sporočil	
function sendDMClicked(){
	sendDMChat();
}
// sprememba sobe
function spremembaDM(){
	var opcija = document.getElementById("izbiraUporabnika").value;
	// alert(opcija);
	$.get("userchange.php", {
		text: opcija
	});
}
// emoji-ji
function dmEmoji(obj){
	document.getElementById("DMInput").value = document.getElementById("DMInput").value + obj.title;
}



// dodajanje sobe
function addRoom(){
	var imeSobe = document.getElementById("addRoom").value;
	if(imeSobe.length < 3){
		alert("Room name has to have at least 3 characters!");
	} else {
		//alert(imeSobe);
		document.getElementById("addRoom").value = "";
		
		$.ajax({
			type: "GET",
			url: 'dodajsobo.php',
			data: {text: imeSobe},
			success: function(data){
				alert(data);
				location.reload(true);
			}
		});
	}
}
// odstranjevanje sobe
function deleteRoom(soba){
	var r = confirm("Are you sure you want to delete room " + soba + "?");
    if (r == true) {
		// alert("Room will be removed...");
		$.ajax({
			type: "GET",
			url: 'delroom.php',
			data: {text: "nic"},
			success: function(data){
				alert(data);
				location.reload(true);
			}
		});
    } else	{
		alert(soba + " wasn't deleted.");
	}
}





// izbris sporočila
function izbrisSporocila(id,x){
	var idIzbrisi = id;
	var chatInfo = x; // iz katerega chat-a brišemo (private ali soba)
	// alert(idIzbrisi + " " + x);
	var r = confirm("Do you want to delete the message?");
	if (r == true) {
		alert("Message deleted!");
		$.get("izbrissporocila.php", {
			text: idIzbrisi
		});
	} else {
		alert("Message remains!");
	}
}
// izbris iz DM
function izbrisSporocilaDM(id){
	var idIzbrisi = id;
	var r = confirm("Do you want to delete the message?");
	if(r == true){
		$.get("izbrissporocilaDM.php", {
			text: idIzbrisi
		});
		alert("Message deleted!");
	} else {
		alert("Message remains!");
	}
}






// blokiranje uporabnika
function blokirajUporabnika(idUp){
	var idBlok = idUp;
	// alert(idBlok);
	
	var r = confirm("Confirm that you want to block(unblock) user.");
    if (r == true) {
		alert("User blocked(unblocked)!");
		$.get("blokiraj.php", {
			text: idBlok
		});
    } else	{
		alert("User is still visible!");
	}
}





// dodajanje prijatelja
function addFriend(){
	var imePrij = document.getElementById("searchUser").value;
	document.getElementById("searchUser").value = "";
	if(imePrij.length < 3){
		alert("Name has to be at least 3 characters long!");
	} else {
		// alert(imePrij);
		/*
		$.get("dodajprijatelja.php", {
			text: imePrij
		});
		var spor = "Konec dodajanja prijatelja";
		alert(spor);
		*/
		$.ajax({
			type: "GET",
			url: 'dodajprijatelja.php',
			data: {text: imePrij},
			success: function(data){
				alert(data);
				location.reload(true);
			}
		});
	}
}
// odstranjevanje prijatelja
function removeFriend(){
	var r = confirm("Are you sure you want to remove selected friend?");
    if (r == true) {
		// alert("Friend will be removed...");
		$.ajax({
			type: "GET",
			url: 'delfriend.php',
			data: {text: "nic"},
			success: function(data){
				alert(data);
				location.reload(true);
			}
		});
    } else	{
		alert("User is still visible!");
	}
}
// izbris uporabnika (sebe)
function delUser(){
	var r = confirm("Are you sure you want to delete your account?");
	if(r == true){
		var n = confirm("Click OK to delete account.");
		if(n == true){
			window.location.href = "index.php?deleteUser=true";
		} else {
			alert("Account wasn't deleted!");
		}
	} else {
		alert("I thought so.");
	}
	
}



// odstranjevanje uporabnika iz sobe
function odstraniIzSobe(idUp){
	var r = confirm("Are you sure you want to delete user from current room?");
	if(r == true){
		$.ajax({
			type: "GET",
			url: 'deluserfromroom.php',
			data: {text: idUp},
			success: function(data){
				alert(data);
			}
		});
	}
}

// promotanje in demotanje uporabnika
function promoteUser(idUp){
	// promotaš ga v moderatorja - admin = 1
	var st = 0; // trenutni status userja v sobi
	var r = confirm("Sure you want to promote?");
	if(r == true){
		// demotaj ga
		$.ajax({
			type: "GET",
			url: 'changeuserrole.php',
			data: {
				"idUp": idUp,
				"xvar": st
			},
			success: function(data){
				alert(data);
			}
		});
		//window.location.href = "index.php";
	}
}
function demoteUser(idUp){
	// demotaš ga v navadenga userja - admin = 0
	var st = 1; // trenutni status userja v sobi
	var r = confirm("Sure you want to demote?");
	if(r == true){
		// demotaj ga
		$.ajax({
			type: "GET",
			url: 'changeuserrole.php',
			data: {
				"idUp": idUp,
				"xvar": st
			},
			success: function(data){
				alert(data);
			}
		});
		//window.location.href = "index.php";
	}
}