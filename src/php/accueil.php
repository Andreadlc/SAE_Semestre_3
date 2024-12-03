<?php

if (isset($_SESSION['success_message_connexion'])) {
    echo "<p style='color: green;'>" . $_SESSION['success_message_connexion'] . "</p>";
    unset($_SESSION['success_message_connexion']); // Supprimez le message après affichage
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include("../includes/header.html"); ?>
</head>
<body>
<?php include("../includes/nav_bar.php"); ?>

<?php include("../includes/main.html"); ?>

<?php include("../includes/footer.html"); ?>
</body>
</html>

