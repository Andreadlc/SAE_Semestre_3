<?php
session_start(); // Nécessaire pour accéder à $_SESSION
?>




<header>
    <img src="img/logo.png" alt="Logo du site">
    <h1>Math My Result</h1>
</header>

<nav>
    <ul>
        <li><a href="accueil.php">Accueil &ensp;</a></li>

        <?php
        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
            // Si l'utilisateur est un administrateur web ou un administrateur système
            if ($_SESSION['role'] == 1) { // Administrateur web
                echo '<li><a href="module.php">Module de Mathématiques</a></li>';
                echo '<li><a href="historique_connexion.php">Historique des connexions</a></li>';
                echo '<li><a href="Delete.php">Désinscription</a></li>';
                echo '<li><a href="AdminLg.php">Déconnexion</a></li>';
            } elseif ($_SESSION['role'] == 2) { // Administrateur système
                echo '<li><a href="adminsystem.php">Administration</a></li>';
                echo '<li><a href="AdminLg.php">Déconnexion</a></li>';
            } else { // Utilisateur normal (role == 0)
                echo '<li><a href="module.php">Module de Mathématiques</a></li>';
                echo '<li><a href="historique_module_maths.php">Historique du module</a></li>';
                echo '<li><a href="form_change_password.php">Changer mon mot de passe</a></li>';
                echo '<li><a href="UserLg.php">Déconnexion</a></li>';

            }
        } else {
            // Si l'utilisateur est un visiteur
            echo '<li><a href="Login.php">Connexion</a></li>';
            echo '<li><a href="Create.php">Inscription</a></li>';
        }
        ?>
    </ul>
</nav>