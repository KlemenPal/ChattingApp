<?php

session_start();

$_SESSION['chat'] = $_GET["text"];
header('Location: index.php');

?>