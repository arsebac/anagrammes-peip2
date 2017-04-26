<?php
require_once "include/jeux.php";


session_start();
if(!isset($_GET["action"])){
    exit("Paramètre manquant");
}
switch ($_GET["action"]){
    case "startPartie":
        startPartie();
        break;
    case "try":
        testMot($_GET["value"]);
        break;
    case "setPseudo":
        $_SESSION["pseudo"] = $_GET["value"];
        echo "ok".$_SESSION["pseudo"];
        break;
    case "reset":
        session_destroy();
        header('Location:newGame.php');
        break;
    case "new":
        nouvellesLettres();
}
// Change les lettres en cours de partie
function nouvellesLettres(){
    $_SESSION["lettres"] = randomLetters();
    echo '{"lettres":"'.$_SESSION["lettres"].'"}';
}
// Vérifie si un mot respecte les règles
function testMot($mot){
    if(verifieMot($_SESSION["lettres"],$mot)){
        $trouve =  motTrouve($mot);
    }else{
        $trouve = false;
    }
    echo json_mot_reponse($trouve,$mot);
}

// Charge les informations de la partie en cours
function startPartie(){
    if(!array_key_exists("pseudo",$_SESSION)){
        echo  json_partie($_SESSION["lettres"],false,"");
    }else{
        echo  json_partie($_SESSION["lettres"],true,$_SESSION["pseudo"]);
    }
}