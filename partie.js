/**
 * Created by Hasaghi on 14/04/2017.
 */
var nombreMots = 0;
var lettres = "????????";
function askPseudo() {
    document.getElementById("jeux").style.display ="none";
    document.getElementById("askPseudo").style.display = "block";
}
function setPseudo() {
    pseudo = document.getElementById("pseudo").value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET',"info.php?action=setPseudo&value="+pseudo);
    xhr.send();
    document.getElementById("jeux").style.display = "block";
    document.getElementById("askPseudo").style.display ="none";
    init(lettres);
}
function loadInformation() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET',"info.php?action=startPartie");
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
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
    console.log("Temps fini !\nVous avez trouvé "+ nombreMots +" mots !");
    window.location.replace("resultat.php");
}
var tempsRestant = 0;
console.log(tempsRestant);
function timer(tps) {
    if(tps !== undefined)
    tempsRestant = tps;
    document.getElementById("chrono").innerHTML = "0:"+tempsRestant;
    console.log(tempsRestant);
    if(tempsRestant === 0){
        tempsFini();
    }else{
        tempsRestant = tempsRestant - 1;
        console.log(tempsRestant);
        setTimeout(timer, 1000)
    }
}
function init(lettres) {
    document.getElementById("chargement").style.display = "none";
    document.getElementById('entree').onkeypress = function(e){
        console.log(e);
        if (!e) e = window.event;
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13'){
            input();
            return false;
        }
    }
    for(i=0;i<8;i++){
        document.getElementById("lettre"+i).innerHTML = lettres[i];
    }
    timer(60);

}
function displayMotTeste(mot, b) {
    var div = document.createElement("div");
    if(b){
        div.className = "bonMot";
        var t = document.createTextNode(mot+" trouvé");
    }else{
        div.className = "mauvaisMot";
        var t = document.createTextNode(mot+" tenté");
    }      // Create a text node
    div.appendChild(t);                                // Append the text to <button>
    document.getElementById("log").appendChild(div);
}
function input() {
    essai = document.getElementById("entree").value;
    document.getElementById("entree").value = "";
    var xhr = new XMLHttpRequest();
    xhr.open('GET',"info.php?action=try&value="+essai);
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                var res = JSON.parse(xhr.responseText);
                if(res.etat == true){
                    nombreMots ++;
                    tempsRestant = tempsRestant + 5;
                    console.log(tempsRestant);
                    displayMotTeste(res.mot,true);
                }else{
                    displayMotTeste(res.mot,false);
                }

            }else{
                console.log("erreur"+xhr.status);
            }
        }
    };
    xhr.send();

}
function shuffle() {
    var position = [ 0,1,2,3,4,5,6,7]
    for(i = 0;i<8;i++){
        index = Math.floor(Math.random() * (8 - i));
        positionIemeLettre = position[index];
        position.splice(index,1);
        document.getElementById("lettre"+positionIemeLettre).innerHTML = lettres[i];
    }
}
function nouvellesLettres() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET',"info.php?action=new");
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
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