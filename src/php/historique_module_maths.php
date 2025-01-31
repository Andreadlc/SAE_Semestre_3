<?php

include("includes/header.html");
include("includes/nav_bar.php");

if (!isset($_SESSION['id'])) {
    header('Location: acces_refuser.php');
    exit();
}

// Connexion à la base de données
$co = mysqli_connect("localhost", "root", "", "bd_sae");
if (!$co) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupération de l'ID de l'utilisateur connecté
$utilisateur_id = $_SESSION['id'];

// Requête pour récupérer les résultats de l'utilisateur
$sql = "SELECT * FROM resultat_probabilite WHERE utilisateur_id = ?";
$stmt = mysqli_prepare($co, $sql);
mysqli_stmt_bind_param($stmt, 'i', $utilisateur_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<div class="historique_module">
    <h1>Historique des Calculs</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">Espérance (μ)</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Forme (λ)</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Valeur (t)</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Nombre de valeurs (n)</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Méthode de calcul</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Valeur de probabilité</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Moyenne (X̄)</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Écart-type (σ)</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Date</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $row['esperance_mu']; ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $row['forme_lambda']; ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $row['valeur_t']; ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $row['nombre_valeurs_n']; ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $row['methode_calcul']; ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $row['valeur_probabilite']; ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $row['moyenne_x']; ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $row['ecart_type_sigma']; ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo date("d/m/Y", strtotime($row['date_calcul'])); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun résultat trouvé.</p>
    <?php endif; ?>

</div>

<?php
mysqli_stmt_close($stmt);
mysqli_close($co);

include("includes/footer.html");
?>
