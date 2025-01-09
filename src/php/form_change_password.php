<?php
include("includes/header.html");
include("includes/nav_bar.php");
?>

<div class="login-container">
    <?php
    // Vérifiez si un message d'erreur ou de succès est défini
    if (isset($_SESSION['error_message'])) {
        echo "<p style='color: #b22222; font-weight: bold;'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']); // Supprime le message après l'avoir affiché
    } elseif (isset($_SESSION['success_message_connexion'])) {
        echo "<p style='color: #006400; font-weight: bold;'>" . $_SESSION['success_message_connexion'] . "</p>";
        unset($_SESSION['success_message_connexion']); // Supprime le message après l'avoir affiché
    }
    ?>

    <br><br><br>

    <fieldset>
        <legend>Changer de mot de passe</legend>
        <form method="post" action="changer_password.php">
            <label for="old_password">Ancien mot de passe</label>
            <input type="password" name="old_password" id="old_password" placeholder="Ancien mot de passe" required>

            <label for="new_password">Nouveau mot de passe</label>
            <input type="password" name="new_password" id="new_password" placeholder="Nouveau mot de passe" required>

            <label for="confirm_password">Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmer le mot de passe" required>

            <input type="submit" name="submit" value="Changer le mot de passe">
        </form>
    </fieldset>
</div>

<?php
include("includes/footer.html");
?>
