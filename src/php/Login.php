<?php
include("includes/header.html");
include("includes/nav_bar.php");
?>

    <div class="login-container">
        <?php
        // Vérifiez si un message d'erreur ou de succès est défini
        if (isset($_SESSION['error_message'])) {
            echo "<p style='color: #b22222; font-weight: bold;'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']); // Supprimez le message après l'avoir affiché
        } elseif (isset($_SESSION['success_message_connexion'])) {
            echo "<p style='color: #006400; font-weight: bold;'>" . $_SESSION['success_message_connexion'] . "</p>";
            unset($_SESSION['success_message_connexion']); // Supprimez le message après l'avoir affiché
        }
        ?>

        <br><br><br>

        <fieldset>
            <legend>Authentification</legend>
            <form method='post' action='Connexion.php'>
                <label for='username'>Nom d'utilisateur</label>
                <input type='text' name='username' id='username' placeholder='Nom utilisateur' required>

                <label for='password'>Mot de passe</label>
                <input type='password' name='password' id='password' placeholder='Mot de passe' required>

                <table>
                    <tr>
                        <td>
                            <label for="captcha">Veuillez entrer le code affiché</label>
                            <input name='captcha' type='text' id="captcha" required>
                            <img src='captcha.php' style='vertical-align: middle;' alt="captcha"/>
                        </td>
                    </tr>
                </table>

                <input type='submit' name='ok' value='Se connecter'>
                <br>
            </form>
        </fieldset>
    </div>

<?php
include("includes/footer.html");
?>