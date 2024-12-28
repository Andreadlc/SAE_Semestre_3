<?php
include("includes/header.html");
include("includes/nav_bar.php");

if ($_SESSION['role'] != 1) {
    header('Location: acces_refuser.php');
    exit();
}

// Affichage des messages de feedback
echo "<br><br><br>";
?>
<div class="main-container">
    <?php
    if (isset($_SESSION['success_delete'])) {
        echo "<p class='success_delete'>" . $_SESSION['success_delete'] . "</p>";
        unset($_SESSION['success_delete']);
    }
    if (isset($_SESSION['error_delete'])) {
        echo "<p class='error_delete'>" . $_SESSION['error_delete'] . "</p>";
        unset($_SESSION['error_delete']);
    }
    ?>
</div>

<?php
// Formulaire de suppression basé sur l'ID et le nom d'utilisateur
echo "<fieldset><legend>Désinscription</legend>
        <form method='post' action='Suppression.php'>
            <label for='user_id'>ID de l'utilisateur</label>
            <input type='number' name='user_id' id='user_id' placeholder='ID utilisateur' >
            <br>
            <label for='username'>Nom d'utilisateur</label>
            <input type='text' name='username' id='username' placeholder='Nom utilisateur'>
            <input type='submit' name='ok' value='Supprimer le compte'>
        </form>
</fieldset>";

include("includes/footer.html");
?>
