<?php
include("includes/header.html");
include("includes/nav_bar.php");
include("ChiffrementRC4/rc4.php");

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
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
?>

<fieldset>
    <legend><h3>Module Crypto - RC4</h3></legend>

    <!-- Formulaire de chiffrement -->
    <div class="form-container">
        <form method="POST">
            <h4>Chiffrement</h4>
            <label for="key_encrypt">Clé :</label>
            <input type="text" name="key_encrypt" id="key_encrypt" required><br>

            <label for="text_encrypt">Texte à chiffrer :</label>
            <textarea name="text_encrypt" id="text_encrypt" required></textarea><br>

            <button type="submit" name="encrypt">Chiffrer</button>
        </form>

        <!-- Formulaire de déchiffrement -->
        <form method="POST">
            <h4>Déchiffrement</h4>
            <label for="key_decrypt">Clé :</label>
            <input type="text" name="key_decrypt" id="key_decrypt" required><br>

            <label for="text_decrypt">Texte chiffré :</label>
            <textarea name="text_decrypt" id="text_decrypt" required></textarea><br>

            <button type="submit" name="decrypt">Déchiffrer</button>
        </form>
    </div>
</fieldset>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<fieldset><legend><h3>Résultat</h3></legend>";

    // Si l'utilisateur a chiffré un texte
    if (isset($_POST["encrypt"]) && isset($_POST["key_encrypt"]) && isset($_POST["text_encrypt"])) {
        $key = $_POST["key_encrypt"];
        $text = $_POST["text_encrypt"];
        $encrypted = strtoupper(bin2hex(rc4($key, $text))); // Chiffrement en hexadécimal

        // Texte original avant chiffrement
        $texte_original = $text;

        echo "<p><strong>Texte chiffré :</strong> $encrypted</p>";

        // Afficher un formulaire pour déchiffrer ce texte immédiatement
        echo "<form method='POST'>
                <input type='hidden' name='key_decrypt' value='" . htmlspecialchars($key) . "'>
                <input type='hidden' name='text_decrypt' value='" . htmlspecialchars($encrypted) . "'>
                <button type='submit' name='decrypt'>Déchiffrer</button>
              </form>";

        // Sauvegarder dans la base de données si le bouton 'save_encrypted' est activé
        if (isset($_POST['save_encrypted'])) {
            $sql = "INSERT INTO historique_crypto (utilisateur_id, cle, texte_original, text, operation) 
                    VALUES (?, ?, ?, ?, 'chiffrement')";
            $stmt = mysqli_prepare($co, $sql);
            // S'assurer que $utilisateur_id est bien défini
            mysqli_stmt_bind_param($stmt, 'isss', $utilisateur_id, $key, $texte_original, $encrypted);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<p style='color: green;'>Résultat sauvegardé avec succès!</p>";
        }

        // Sauvegarde dans un autre formulaire si nécessaire
        echo "<form action='sauvegarde_resultat_crypto.php' method='POST'>
                <input type='hidden' name='key_encrypt' value='" . htmlspecialchars($key) . "'>
                <input type='hidden' name='text_encrypt' value='" . htmlspecialchars($encrypted) . "'>
                <input type='hidden' name='texte_original' value='" . htmlspecialchars($texte_original) . "'>
                <input type='hidden' name='operation' value='chiffrement'>
                <button type='submit' name='save_encrypted'>Sauvegarder le résultat</button>
              </form>";
    }

    // Si l'utilisateur a déchiffré un texte
    if (isset($_POST["decrypt"]) && isset($_POST["key_decrypt"]) && isset($_POST["text_decrypt"])) {
        $key = $_POST["key_decrypt"];
        $text = $_POST["text_decrypt"];

        if (ctype_xdigit($text)) { // Vérifie si le texte est bien en hexadécimal
            $decrypted = rc4($key, hex2bin($text));

            // Texte original avant déchiffrement
            $texte_original = $text;

            echo "<p><strong>Texte déchiffré :</strong> $decrypted</p>";

            // Sauvegarder dans la base de données
            if (isset($_POST['save_decrypted'])) {
                $sql = "INSERT INTO historique_crypto (utilisateur_id, cle, texte_original, text, operation) 
                        VALUES (?, ?, ?, ?, 'dechiffrement')";
                $stmt = mysqli_prepare($co, $sql);
                // S'assurer que $utilisateur_id est bien défini
                mysqli_stmt_bind_param($stmt, 'isss', $utilisateur_id, $key, $texte_original, $decrypted);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo "<p style='color: green;'>Résultat sauvegardé avec succès!</p>";
            }

            echo "<form action='sauvegarde_resultat_crypto.php' method='POST'>
                <input type='hidden' name='key_encrypt' value='" . htmlspecialchars($key) . "'>
                <input type='hidden' name='text_encrypt' value='" . htmlspecialchars($decrypted) . "'>
                <input type='hidden' name='texte_original' value='" . htmlspecialchars($texte_original) . "'>
                <input type='hidden' name='operation' value='dechiffrement'>
                <button type='submit' name='save_encrypted'>Sauvegarder le résultat</button>
              </form>";
        } else {
            echo "<p style='color:red;'><strong>Erreur :</strong> Le texte chiffré n'est pas valide !</p>";
        }
    }

    echo "</fieldset>";
}

// Fermer la connexion à la base de données
mysqli_close($co);
?>

<?php
include("includes/footer.html");
?>
