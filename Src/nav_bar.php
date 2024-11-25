<?php
session_start(); // Nécessaire pour accéder à $_SESSION
?>

<body>

<header>
  <img src="./img/logo.png" alt="Logo du site">
  <h1>Math My Result</h1>
</header>


<nav>
  <ul>
    <li class="deroulant"><a href="accueil.php">Accueil &ensp;</a>
      <ul class="sous">
        <li><a href="#presentation">Présentation</a></li>
        <li><a href="#video">Vidéo</a></li>
      </ul></li>

      <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
          <!-- Affiche ce lien uniquement si l'utilisateur est connecté -->
          <li><a href="module.php">Module de Mathématiques</a></li>
          <li><a href="UserLg.php">Déconnexion</a></li>
      <?php endif; ?>
    <li><a href="connexion.php">Connexion</a></li>
    <li><a href="Create.php">Inscription</a></li>


  </ul>
</nav>