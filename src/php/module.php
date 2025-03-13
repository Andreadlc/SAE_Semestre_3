<?php
include("includes/header.html");
include("includes/nav_bar.php");
include("form.php");

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: acces_refuser.php');
    exit();
}
?>
<div class="registration-container">
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<p style='color: #006400;'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']); // Supprime le message après l'affichage
    }

    if (isset($_SESSION['error_message'])) {
        echo "<p style='color: #b22222;'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']); // Supprime le message après l'affichage
    }
    ?>
</div>
<?php
// Traitement des données si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("form_processus.php");
}


include("includes/footer.html");
?>



