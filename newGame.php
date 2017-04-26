<?php
require_once "include/jeux.php";
// Crée une nouvelle partie
session_start();
$_SESSION["lettres"] = randomLetters();
$_SESSION["trouves"] = array();
header('Location:partie.html');