<?php



include_once("Delete.php");


if (isset($_POST['ok'], $_POST['username'], $_POST['password'])) {

    $uname = $_POST['username'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $co = mysqli_connect("localhost", "root", ""); // Utilisez "localhost" ici


    if (!$co) {
        die("La connexion a échoué : " . mysqli_connect_error());
    }

    // Sélection de la base de données
    $bd = mysqli_select_db($co, "test"); // Assurez-vous que "test" est bien le nom de votre base de données
    if (!$bd) {
        die("Impossible de sélectionner la base de données : " . mysqli_error($co));
    }


    // Définition des requêtes
    $table = "client"; // Table où les données des utilisateurs sont stockées

    // Hachage du mot de passe avec MD5
    $password_md5 = md5($password); // Hash MD5 du mot de passe

    $dsureql = "SELECT * FROM $table WHERE login = '$uname' AND mdp = '$password_md5'"; // Requête de vérification des données

    $deleteql = "DELETE FROM $table WHERE login = '$uname' AND mdp = '$password_md5'"; // Requête de desinscription

    // Exécution des requêtes de vérification
    $resultd = mysqli_query($co, $dsureql);


    if ($resultd) {
        $rowd = mysqli_fetch_assoc($resultd);

        if ($rowd) {
            mysqli_query($co, $deleteql);
            echo "Votre compte a été supprimé avec succès";
        } else {
            echo "Données inexistantes";
        }
    } else {
        echo "Erreur de requête : " . mysqli_error($co);
    }

    // Fermer la connexion
    mysqli_close($co);
}
?>