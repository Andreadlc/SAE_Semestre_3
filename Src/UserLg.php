<?php



session_start();
// Terminer la session
session_destroy(); // Détruit la session et ses données

header("location:accueil.php");