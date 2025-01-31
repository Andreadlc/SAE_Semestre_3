<?php

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include("includes/header.html"); ?>
</head>
<body>
<?php include("includes/nav_bar.php"); ?>
<div class="main-container">
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<p class='success-message'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']);
    }
    ?>
</div>
<?php include("includes/main.html"); ?>

<?php include("includes/footer.html"); ?>
</body>
</html>

