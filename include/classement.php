<h1>Classement</h1>
<ul id='classement'>
    <?php
    define("FILE", "donnees/score.txt");
    define("MAX_ITEM", 10);
    $classement = array();
    function recupererClassement()
    {
        $array = file(FILE);
        $classement = array();
        for ($i = 0; $i < min(count($array), MAX_ITEM); $i++) {
            $classement[$i] = explode(";", $array[$i]);
            $classement[$i][0] = intval($classement[$i][0]);
        }
        return $classement;
    }

    function addToClassement($nom, $resultat)
    {
        $classement = recupererClassement();
        $len = count($classement);
        if ($classement[$len - 1][0] > $resultat && $len > MAX_ITEM) {
            return false;
        }
        for ($i = $len; $i >= 0; $i--) {
            $classement[$i][0] = $classement[$i - 1][0];
            $classement[$i][1] = $classement[$i - 1][1];
            if ($classement[$i][0] > $resultat) {
                $classement[$i] = array($resultat, $nom . "\n");
                break;
            }
        }
        save_classement($classement);
    }

    function save_classement($classement)
    {
        $str = "";
        for ($i = 0; $i < count($classement); $i++) {
            $str .= $classement[$i][0] . ";" . $classement[$i][1];
        }
        file_put_contents(FILE, $str);
    }
if(var_session_exists("trouves")){
    addToClassement($_SESSION["pseudo"], count($_SESSION["trouves"]));
}
    $i = 1;
    $z = recupererClassement();
    foreach ($z as $item) {
        echo "<li>" . $i . ". " . $item[1] . " a trouvé " . $item[0] . " mots.</li>";
        $i++;
    }
    ?>

</ul>