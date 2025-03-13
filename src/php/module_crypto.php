<?php

include("includes/header.html");
include("includes/nav_bar.php");
include("ChiffrementRC4/rc4.php");

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: acces_refuser.php');
    exit();
}
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
        $encrypted = strtoupper(bin2hex(rc4($key, $text)));

        echo "<p><strong>Texte chiffré :</strong> $encrypted</p>";

        // Afficher un formulaire pour déchiffrer ce texte immédiatement
        echo "<form method='POST'>
                <input type='hidden' name='key_decrypt' value='" . htmlspecialchars($key) . "'>
                <input type='hidden' name='text_decrypt' value='" . htmlspecialchars($encrypted) . "'>
                <button type='submit' name='decrypt'>Déchiffrer</button>
              </form>";
    }

    // Si l'utilisateur a déchiffré un texte
    if (isset($_POST["decrypt"]) && isset($_POST["key_decrypt"]) && isset($_POST["text_decrypt"])) {
        $key = $_POST["key_decrypt"];
        $text = $_POST["text_decrypt"];

        if (ctype_xdigit($text)) { // Vérifie si le texte est bien en hexadécimal
            $decrypted = rc4($key, hex2bin($text));
            echo "<p><strong>Texte déchiffré :</strong> $decrypted</p>";

            // Afficher un formulaire pour rechiffrer ce texte immédiatement
            echo "<form method='POST'>
                    <input type='hidden' name='key_encrypt' value='" . htmlspecialchars($key) . "'>
                    <input type='hidden' name='text_encrypt' value='" . htmlspecialchars($decrypted) . "'>
                    <button type='submit' name='encrypt'>Chiffrer</button>
                  </form>";
        } else {
            echo "<p style='color:red;'><strong>Erreur :</strong> Le texte chiffré n'est pas valide !</p>";
        }
    }

    echo "</fieldset>";
}
?>

<?php
include("includes/footer.html");
?>
