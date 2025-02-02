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

?><fieldset>
    <legend>
        <h3>Historique des Calculs</h3>
    </legend>
    <div class="historique_module">

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Méthode</th>
                    <th>Valeur de probabilité</th>
                    <th><span class="sr-only">Colonne vide</span></th>
                    <th>Moyenne (X̄)</th>
                    <th>Écart-type (σ)</th>
                    <th>Espérance (μ)</th>
                    <th>Forme (λ)</th>
                    <th>Valeur (t)</th>
                    <th>Nombre (n)</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($row['date_calcul'])); ?></td>
                        <td><?php echo $row['methode_calcul']; ?></td>
                        <td><?php echo $row['valeur_probabilite']; ?></td>
                        <td></td>
                        <td><?php echo $row['moyenne_x']; ?></td>
                        <td><?php echo $row['ecart_type_sigma']; ?></td>
                        <td><?php echo $row['esperance_mu']; ?></td>
                        <td><?php echo $row['forme_lambda']; ?></td>
                        <td><?php echo $row['valeur_t']; ?></td>
                        <td><?php echo $row['nombre_valeurs_n']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    </div>
</fieldset>






<?php
mysqli_stmt_close($stmt);
mysqli_close($co);

include("includes/footer.html");
?>
