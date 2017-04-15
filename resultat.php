<?php
require_once "include/jeux.php";
require_once "include/classement.php";
/**
 * Created by PhpStorm.
 * User: Hasaghi
 * Date: 14/04/2017
 * Time: 23:01
 */
session_start();
if(!var_session_exists("lettres")||! var_session_exists("trouves")) {
    header('Location:newGame.php');
}
require "include/resultHeader.html";
?>
<?php
    ?>

    <h1> Résultat de votre partie </h1>
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
    <?php
    $_SESSION["lettres"] = "";
    session_destroy();
?>
    <h1>
        <a href="newGame.php">Relancer une partie</a><br>
    </h1>
<br/>
    <div class="fb-share-button" data-href="http://beyselnian.free.fr/anagrammes/" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fbeyselnian.free.fr%2Fanagrammes%2F&amp;src=sdkpreparse">Partager</a></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
