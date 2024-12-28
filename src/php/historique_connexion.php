<?php

include("includes/header.html");
include("includes/nav_bar.php");

if ($_SESSION['role'] != 1) {
    header('Location: acces_refuser.php');
    exit();
}

// Connexion à la base de données
$co = mysqli_connect("localhost", "root", "", "bd_sae");
if (!$co) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupération des utilisateurs
$sql = "SELECT id, nom_utilisateur,date_creation FROM utilisateur";
$result = mysqli_query($co, $sql);
?>
    <fieldset>
        <legend>Liste des utilisateurs</legend>
        <table border="1">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Date de creation</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nom_utilisateur']; ?></td>
                    <td><?php echo $row['date_creation']; ?></td>
                    <td>

                        <a href="Delete.php"><button type="submit">Supprimer</button></a>


                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <a href="import_csv.php">Importer un fichier CSV</a>
    </fieldset>


<?php
include("includes/footer.html");
?>