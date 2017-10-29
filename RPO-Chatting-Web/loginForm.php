<?php
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/forms.css">
    </head>
    <body>
		<div class="forma">
		<form class="obrazec" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<header>Login</header>
			<p>Username:</p> <input type="text" pattern=".{3,}" required title="Minium 3 chars!" placeholder="Type Username" name="user">
			<br>
			<p>Password:</p> <input type="password" pattern=".{3,}" required title="Minium 3 chars!" placeholder="Type Password" name="pass">
			<br>
			<input type="submit" value="Login" name="submit">
		</form>
		</div>
		
		<p align="center"><a href="registracija.php">Register</a></p>
    </body>
</html>