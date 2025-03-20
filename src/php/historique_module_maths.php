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

// Récupérer les résultats du polynôme de degré 2
$sql_polynome = "SELECT * FROM resultat_polynome WHERE utilisateur_id = ?";
$stmt_polynome = mysqli_prepare($co, $sql_polynome);
mysqli_stmt_bind_param($stmt_polynome, 'i', $utilisateur_id);
mysqli_stmt_execute($stmt_polynome);
$result_polynome = mysqli_stmt_get_result($stmt_polynome);

// Récupérer les résultats de probabilités
$sql_probabilite = "SELECT * FROM resultat_probabilite WHERE utilisateur_id = ?";
$stmt_probabilite = mysqli_prepare($co, $sql_probabilite);
mysqli_stmt_bind_param($stmt_probabilite, 'i', $utilisateur_id);
mysqli_stmt_execute($stmt_probabilite);
$result_probabilite = mysqli_stmt_get_result($stmt_probabilite);

// Récupérer les résultats de crypto
$sql_crypto = "SELECT * FROM historique_crypto WHERE utilisateur_id = ?";
$stmt_crypto = mysqli_prepare($co, $sql_crypto);
mysqli_stmt_bind_param($stmt_crypto, 'i', $utilisateur_id);
mysqli_stmt_execute($stmt_crypto);
$result_crypto = mysqli_stmt_get_result($stmt_crypto);
?>

<fieldset>
    <legend><h3>Historique des Calculs</h3></legend>
    <div class="historique_module">

        <!-- Affichage des résultats des polynômes de degré 2 -->
        <h4>Historique des résultats de polynômes de degré 2</h4>
        <?php if (mysqli_num_rows($result_polynome) > 0): ?>
            <table>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Équation</th>
                    <th>Discriminant</th>
                    <th>Racine 1</th>
                    <th>Racine 2</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_polynome)): ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($row['date_calcul'])); ?></td>
                        <td><?php echo "{$row['coefficient_a']}x² + {$row['coefficient_b']}x + {$row['coefficient_c']} = 0"; ?></td>
                        <td><?php echo $row['discriminant']; ?></td>
                        <td><?php echo $row['racine_1'] ? $row['racine_1'] : 'N/A'; ?></td>
                        <td><?php echo $row['racine_2'] ? $row['racine_2'] : 'N/A'; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun résultat trouvé pour les polynômes de degré 2.</p>
        <?php endif; ?>

        <!-- Affichage des résultats des probabilités -->
        <h4>Historique des résultats de probabilités</h4>
        <?php if (mysqli_num_rows($result_probabilite) > 0): ?>
            <table>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Méthode</th>
                    <th>Valeur de probabilité</th>
                    <th>Moyenne (X̄)</th>
                    <th>Écart-type (σ)</th>
                    <th>Espérance (μ)</th>
                    <th>Forme (λ)</th>
                    <th>Valeur (t)</th>
                    <th>Nombre (n)</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_probabilite)): ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($row['date_calcul'])); ?></td>
                        <td><?php echo $row['methode_calcul']; ?></td>
                        <td><?php echo $row['valeur_probabilite']; ?></td>
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
            <p>Aucun résultat trouvé pour les calculs de probabilité.</p>
        <?php endif; ?>

        <h4>Historique des résultats de Crypto (Chiffrement/Déchiffrement)</h4>
        <?php if (mysqli_num_rows($result_crypto) > 0): ?>
            <table>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Clé utilisée</th>
                    <th>Opération</th>
                    <th>Texte original</th>
                    <th>Texte résultant</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_crypto)): ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($row['date_calcul'])); ?></td>
                        <td><?php echo htmlspecialchars($row['cle']); ?></td>
                        <td><?php echo ucfirst($row['operation']); ?></td>
                        <td><?php echo isset($row['texte_original']) ? htmlspecialchars($row['texte_original']) : 'N/A'; ?></td>
                        <td><?php echo isset($row['text']) ? htmlspecialchars($row['text']) : 'N/A'; ?></td>

                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun résultat trouvé pour les calculs de crypto.</p>
        <?php endif; ?>


    </div>
</fieldset>

<?php
mysqli_stmt_close($stmt_polynome);
mysqli_stmt_close($stmt_probabilite);
mysqli_stmt_close($stmt_crypto);
mysqli_close($co);

include("includes/footer.html");
?>
