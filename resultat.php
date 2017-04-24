<?php
require_once "include/jeux.php";

session_start();

if (!var_session_exists("lettres") || !var_session_exists("trouves")) {
    header('Location:newGame.php');
}
require "include/resultHeader.html";
require_once "include/classement.php";
?>
<?php
?>
    <h1> Résultat de votre partie </h1>
    <div id="resultat">
        <table>
            <tr id="lettresTires">
                <td>Nombre de mots trouvés :</td>
                <td><?php echo count($_SESSION["trouves"]); ?></td>
            </tr>
            <tr>
                <td>Mots trouvés</td>
                <td>
                    <ul>
                        <?php
                        for ($i = 0; $i < count($_SESSION["trouves"]); $i++) {
                            echo "<li class='mot'>" . $_SESSION["trouves"][$i] . "</li>";
                        }
                        ?>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
    <h1>
        <a href="newGame.php">Relancer une partie</a><br>
    </h1>
    <br/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <a title="send to Facebook"
       href="http://www.facebook.com/sharer.php?s=100&p[title]=Anagrammes&description=J%27ai%20trouvé%20<?php echo count($_SESSION["trouves"]); ?>%20anagrammes.%20Qui%20peut%20me%20battre%20?&p[url]=http%3A%2F%2Fbeyselnian.free.fr%2Fanagrammes%2F"
       target="_blank">
  <span>
    Partager sur Facebook
  </span>
    </a><br/>
    <a class="twitter-share-button"
       href="https://twitter.com/intent/tweet?text=J%27ai%20trouvé%20<?php echo count($_SESSION["trouves"]); ?>%20anagrammes.%20Qui%20peut%20me%20battre%20?">
        Partager sur Twitter</a>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
    </html>

<?php
$_SESSION["lettres"] = "";
$_SESSION["trouves"] = array();
?>