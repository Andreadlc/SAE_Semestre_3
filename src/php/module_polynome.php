<?php
include("includes/header.html");
include("includes/nav_bar.php");

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: acces_refuser.php');
    exit();
}

$equation = ""; // Initialisation de l'équation
$discriminant = ""; // Initialisation du discriminant
$result = ""; // Initialisation du résultat
$button_display = "none"; // Initialisation de la visibilité du bouton

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = isset($_POST['a']) ? floatval($_POST['a']) : 0;
    $b = isset($_POST['b']) ? floatval($_POST['b']) : 0;
    $c = isset($_POST['c']) ? floatval($_POST['c']) : 0;

    if ($a == 0) {
        $result = "Ce n'est pas une équation quadratique (a ≠ 0).";
    } else {
        $delta = ($b * $b) - (4 * $a * $c);
        $discriminant = "Le discriminant est : $$\\Delta = b^2 - 4ac = ({$b})^2 - 4({$a})({$c}) = " . ($b * $b) . " - " . (4 * $a * $c) . " = $delta$$";

        $equation = "$a x^2 + $b x + $c = 0";

        if ($delta > 0) {
            $x1 = round((-$b + sqrt($delta)) / (2 * $a), 2);
            $x2 = round((-$b - sqrt($delta)) / (2 * $a), 2);
            $racine_1 = (string) $x1;
            $racine_2 = (string) $x2;

            $result = "Les racines sont réelles et distinctes :<br>";
            $result .= "<p>$$ x₁ = \\frac{-($b) + \\sqrt{$delta}}{2({$a})} = $x1 $$</p>";
            $result .= "<p>$$ x₂ = \\frac{-($b) - \\sqrt{$delta}}{2({$a})} = $x2 $$</p>";

        } elseif ($delta == 0) {
            $x = round(-$b / (2 * $a), 2);
            $racine_1 = (string) $x;
            $racine_2 = (string) $x;

            $result = "Les racines sont réelles et identiques :<br>";
            $result .= "<p>$$ x = \\frac{-($b)}{2({$a})} = $x $$</p>";

        } else {
            $realPart = round(-$b / (2 * $a), 2);
            $imaginaryPart = round(sqrt(abs($delta)) / (2 * $a), 2);
            $racine_1 = "$realPart + {$imaginaryPart}i";
            $racine_2 = "$realPart - {$imaginaryPart}i";

            $result = "Les racines sont complexes :<br>";
            $result .= "<p>$$ x₁ = $racine_1 $$</p>";
            $result .= "<p>$$ x₂ = $racine_2 $$</p>";
        }

        // Affiche le bouton après un calcul
        $button_display = "block";
    }
}
?>
<div class="registration-container">
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<p style='color: #006400;'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']); // Supprime le message après l'affichage
    }

    if (isset($_SESSION['error_message'])) {
        echo "<p style='color: #b22222;'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']); // Supprime le message après l'affichage
    }
    ?>
</div>
<fieldset>
    <legend><h3>Module Polynôme - Degré 2</h3></legend>
    <div class="form-container">
        <form method="POST">
            <h4>Résolution de ax² + bx + c = 0</h4>
            <label for="a">Coefficient a :</label>
            <input type="number" name="a" id="a" required step="any"><br>

            <label for="b">Coefficient b :</label>
            <input type="number" name="b" id="b" required step="any"><br>

            <label for="c">Coefficient c :</label>
            <input type="number" name="c" id="c" required step="any"><br>

            <button type="submit">Calculer</button>
        </form>
    </div>
</fieldset>

<?php if (isset($result)): ?>
    <br><br>
    <div style="text-align: center; margin: 20px;">
        <h3>Formule de l'équation quadratique</h3>
        <p id="mathFormula">$$ <?php echo $equation; ?> $$</p>
    </div>

    <br><br>
    <div style="text-align: center; margin: 20px;">
        <h3>Calcul du discriminant</h3>
        <p id="discriminantFormula"><?php echo $discriminant; ?></p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/3.2.2/es5/tex-mml-chtml.min.js"></script>
    <script>
        MathJax.typeset();
    </script>

    <br><br><br>
    <fieldset>
        <legend>Résultat</legend>
        <p><strong><?php echo $discriminant; ?></strong></p>
        <p><strong>Les racines :</strong></p>
        <p id="mathResult"><?php echo $result; ?></p>

        <!-- Le bouton de sauvegarde est caché au début et affiché après un calcul -->
        <form action="sauvegarde_resultat_polynome.php" method="post" style="display: <?php echo $button_display; ?>;">
            <input type="hidden" name="a" value="<?php echo $a; ?>">
            <input type="hidden" name="b" value="<?php echo $b; ?>">
            <input type="hidden" name="c" value="<?php echo $c; ?>">
            <input type="hidden" name="discriminant" value="<?php echo $delta; ?>">
            <input type="hidden" name="racine_1" value="<?php echo $racine_1; ?>">
            <input type="hidden" name="racine_2" value="<?php echo $racine_2; ?>">
            <button type="submit" id="button_sauvegarde">Sauvegarder vos résultats</button>
        </form>
    </fieldset>
<?php else: ?>
    <p>Veuillez soumettre le formulaire pour obtenir les résultats.</p>
<?php endif; ?>

<?php
include("includes/footer.html");
?>
