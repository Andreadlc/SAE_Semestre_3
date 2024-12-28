<?php

include("includes/header.html");
include("includes/nav_bar.php");
?>

<div class="registration-container">
    <?php
    // Afficher les messages de succès ou d'erreur si disponibles
    if (isset($_SESSION['success_message'])) {
        echo "<p style='color: #006400; font-weight: bold;'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']); // Supprimer le message après l'affichage
    } elseif (isset($_SESSION['error_message'])) {
        echo "<p style='color: #b22222; font-weight: bold;'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']); // Supprimer le message après l'affichage
    }
    ?>

    <br><br><br>

    <fieldset>
        <legend>Inscription</legend>
        <form method="post" action="Insertion.php">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" placeholder="Nom utilisateur" required>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>

            <table>
                <tr>
                    <td>
                        <label for="captcha">Veuillez entrer le code affiché</label>
                        <input name='captcha' type='text' id="captcha" required>
                        <img src='captcha.php' style='vertical-align: middle;' alt="captcha"/>
                    </td>
                </tr>
            </table>

            <input type="submit" name="ok" value="Créer le compte">
            <br>
        </form>
    </fieldset>
</div>

<?php
include("includes/footer.html");
?>
