<?php
require_once "include/jeux.php";
/**
 * Created by PhpStorm.
 * User: Hasaghi
 * Date: 14/04/2017
 * Time: 20:08
 */
session_start();
$_SESSION["lettres"] = randomLetters();
$_SESSION["trouves"] = array();
header('Location:partie.html');