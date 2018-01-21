<?php

session_start();

$_SESSION['DMchat'] = $_GET["text"];
header('Location: index.php');

?>