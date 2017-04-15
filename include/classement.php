
<h1>Classement</h1>
<ul id='classement'>
<?php
/**
 * Created by PhpStorm.
 * User: Hasaghi
 * Date: 15/04/2017
 * Time: 00:27
 */


// Ne marche pas.
function recupererClassement(){
    $array = file("../donnees/score");
    $class = array();
    for($i=0;$i<count($array);$i++){
        $class[$i] = explode(";", $array[$i]);
    }
    return $class;
}

$i = 1;
    $z = recupererClassement();
    foreach ($z as $item){
        echo "<li>".$i.". ".$item[1]." a trouvé ".$item[0]." mots.</li>";
    }
?>
</ul>