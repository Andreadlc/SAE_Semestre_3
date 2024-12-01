<?php
session_start(); // Nécessaire pour accéder à $_SESSION
?>



<body>

<header>
  <img src="../img/logo.png" alt="Logo du site">
  <h1>Math My Result</h1>
</header>

<nav>
  <ul>
    <li><a href="../acceuil/accueil.php">Accueil &ensp;</a></li>

      <?php
      if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
          if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin') {
              // Si l'utilisateur est un administrateur
              echo '<li><a href="../modules/module.php">Module de Mathématiques</a></li>';
              echo '<li><a href="../admin_reseau/historique_connexion.php">Historique des connexions</a></li>';
              echo '<li><a href="../admin_reseau/AdminLg.php">Déconnexion</a></li>';
          } else {
              // Si l'utilisateur est un utilisateur normal
              echo '<li><a href="../modules/module.php">Module de Mathématiques</a></li>';
              echo '<li><a href="../connection/historique_module_maths.php">Historique du module</a></li>';
              echo '<li><a href="../connection/UserLg.php">Déconnexion</a></li>';
          }
      } else {
          // Si l'utilisateur est un visiteur
          echo '<li><a href="../connection/Connexion.php">Connexion</a></li>';
          echo '<li><a href="../inscription/Create.php">Inscription</a></li>';
      }
      ?>
  </ul>
</nav>