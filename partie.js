var nombreMots = 0;
var lettres = "????????";
var pseudo;
var tempsRestant = 0;
// Fonction permettant d'afficher la partie de la fenêtre demandant le pseudo de l'utilisateur
function askPseudo() {
    document.getElementById("jeux").style.display ="none";
    document.getElementById("askPseudo").style.display = "block";
}
// Fonction appelée quand le pseudo est entré
function setPseudo() {
    pseudo = document.getElementById("pseudo").value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET',"info.php?action=setPseudo&value="+pseudo);
    xhr.send();
    document.getElementById("jeux").style.display = "block";
    document.getElementById("askPseudo").style.display ="none";
    init(lettres);
}
// Charge les informations de la partie
function loadInformation() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET',"info.php?action=startPartie");
    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4){
            if(xhr.status === 200){
                var res = JSON.parse(xhr.responseText);
                lettres = res.lettres;
                if(!res.hasPseudo){
                    askPseudo();
                }else{
                    init(lettres);
                }
            }else{
                console.log("erreur"+xhr.status);
            }
        }
    };
    xhr.send();
}

function tempsFini() {
    window.location.replace("resultat.php");
}

// Chronomètre de la partie
function timer(tps) {
    if(tps !== undefined)
    tempsRestant = tps;
    document.getElementById("chrono").innerHTML = "0:"+tempsRestant;
    if(tempsRestant === 0){
        tempsFini();
    }else{
        tempsRestant = tempsRestant - 1;
        setTimeout(timer, 1000)
    }
}
// Fonction appelée lors du lancement de la partie
function init(lettres) {
    document.getElementById("chargement").style.display = "none";
    document.getElementById('entree').onkeypress = function(e){
        if (!e) e = window.event;
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13'){ // Touche entrée détectée
            input();
            return false;
        }
        return true;
    }
    for(i=0;i<8;i++){
        document.getElementById("lettre"+i).innerHTML = lettres[i];
    }
    timer(60);

}
// Affiche le retour sur un mot rendu
// Selon si le mot est valide ou pas
function displayMotTeste(mot, motCorrect) {
    var div = document.createElement("div");
    if(motCorrect){
        div.className = "bonMot";
        var t = document.createTextNode(mot+" trouvé");
    }else{
        div.className = "mauvaisMot";
        var t = document.createTextNode(mot+" tenté");
    }      // Create a text node
    div.appendChild(t);
    document.getElementById("log").appendChild(div);
}

// Méthode appelée lorsqu'un mot est entré.
// Envoie le mot au serveur qui vérifie sa validité
function input() {
    essai = document.getElementById("entree").value;
    document.getElementById("entree").value = "";
    var xhr = new XMLHttpRequest();
    xhr.open('GET',"info.php?action=try&value="+essai);
    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4){
            if(xhr.status === 200){
                var reponse = JSON.parse(xhr.responseText);
                if(reponse.etat == true){
                    nombreMots ++;
                    tempsRestant = tempsRestant + 5;
                    displayMotTeste(reponse.mot,true);
                }else{
                    displayMotTeste(reponse.mot,false);
                }

            }else{
                console.log("erreur"+xhr.status);
            }
        }
    };
    xhr.send();

}
// Permet de mélanger l'ordre d'affichage des lettres
function shuffle() {
    var position = [ 0,1,2,3,4,5,6,7];
    for(i = 0;i<8;i++){
        index = Math.floor(Math.random() * (8 - i));
        positionIemeLettre = position[index];
        position.splice(index,1);
        document.getElementById("lettre"+positionIemeLettre).innerHTML = lettres[i];
    }
}

// Méthode pour renouveller les lettres au cours d'une partie
function nouvellesLettres() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET',"info.php?action=new");
    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4){
            if(xhr.status === 200){
                var res = JSON.parse(xhr.responseText);
                lettres = res.lettres;
                shuffle();
            }else{
                console.log("erreur"+xhr.status);
            }
        }
    };
    xhr.send();
}