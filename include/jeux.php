<?php

// Permet de tirer une lettre aléatoirement
function getLetter(){
    $alphabet = "abcdefghijklmnopqrstuvwxyz";
    return substr($alphabet, rand(0,25), 1);
}
//Permet de tirer une voyelle aléatoirement
function getVoyelle(){
    $voyelles = "aeiouy";
    return substr($voyelles, rand(0,5), 1);
}
// Tire un mot de 8 lettres avec 2 voyelles minimum
function randomLetters()
{
    $nbVoyellesMin = 2;
    $lettres = "";
    for ($i = 0; $i < 8; $i++) {
        if($i<$nbVoyellesMin) {

            $lettres .= getVoyelle();
        }else{
            $lettres .= getLetter();

        }
    }
    return $lettres;
}

function json_partie($letters,$has,$pseudo){

    if(!$has){
        return json_encode(array("lettres"=>$letters,"hasPseudo"=> false));
    }
    return json_encode(array("lettres"=>$letters,"hasPseudo"=>true,"pseudo"=>$pseudo));
}
function json_mot_reponse($etat,$mot){
    return json_encode(array("mot" => $mot,
                              "etat" => $etat));

}
// Vérifie si chaque lettre du mot entré est dans les lettres proposées
// Autrement dit, vérifie si $tentative est uniquement composé de lettres du mot $lettres
function verifieMot($lettres,$tentative){
    for ($i = 0; $i < strlen($tentative); $i++){
        if (strpos($lettres, $tentative[$i]) === false) {
            return false;
        }
    }
    return !array_key_exists($tentative,$_SESSION["trouves"]);
}
// Regarde si un mot entré se trouve dans le dictionnaire
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
// Vérifie si une variable de session est définie
function var_session_exists($name){
    return !(!array_key_exists($name, $_SESSION) || $_SESSION[$name] == '');
}