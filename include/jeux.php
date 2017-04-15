<?php
/**
 * Created by PhpStorm.
 * User: Hasaghi
 * Date: 14/04/2017
 * Time: 20:18
 */

function getLetter(){
    $alphabet = "abcdefghijklmnopqrstuvwxyz";
    return substr($alphabet, rand(0,25), 1);
}
function randomLetters()
{
    $lettres = "";
    for ($i = 0; $i < 8; $i++) {
       $lettres .= getLetter();
    }
    return $lettres;
}
function registerPartie(){
    echo "jeux.php registerPartie()";
}

function json_partie($letters){
    return json_encode(array("lettres"=>$letters));
}
function json_mot_reponse($etat,$mot){
    return json_encode(array("mot" => $mot,
                              "etat" => $etat));

}
function verifieMot($lettres,$tentative){
    for ($i = 0; $i < strlen($tentative); $i++){
        if (strpos($lettres, $tentative[$i]) === false) {
            return false;
        }
    }
    return !array_key_exists($tentative,$_SESSION["trouves"]);
}
function motTrouve($mot){
    $dico = simplexml_load_file("donnees/dico.xml");
    $section = $dico->xpath('/sections/section[@size="'.strlen($mot).'"]/mot');
    foreach ($section as $motDico) {
        if((string)$motDico == $mot) {
            array_push($_SESSION["trouves"],$mot);
            return true;
        }
    }
    return false;
}
function var_session_exists($name){
    return !((!isset($_SESSION[$name])) || $_SESSION[$name] == '');
}
function afficher_classement(){
    echo "<ul id='classement'>";

}