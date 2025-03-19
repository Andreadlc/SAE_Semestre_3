<?php
include("includes/header.html");
include("includes/nav_bar.php");

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: acces_refuser.php');
    exit();
}

$equation = ""; // Initialisation de $equation
$discriminant = ""; // Initialisation de $discriminant
$result = ""; // Initialisation de $result

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = isset($_POST['a']) ? floatval($_POST['a']) : 0;
    $b = isset($_POST['b']) ? floatval($_POST['b']) : 0;
    $c = isset($_POST['c']) ? floatval($_POST['c']) : 0;

    if ($a == 0) {
        $result = "Ce n'est pas une équation quadratique (a ≠ 0).";
    } else {
        $delta = ($b * $b) - (4 * $a * $c);
        $discriminant = "Le discriminant est : $$\\Delta = b^2 - 4ac = ({$b})^2 - 4({$a})({$c}) = " . ($b * $b) . " - " . (4 * $a * $c) . " = $delta$$";

        // Formule d'affichage du discriminant et des racines
        $equation = "$a x^2 + $b x + $c = 0";

        if ($delta > 0) {
            $x1 = (-$b + sqrt($delta)) / (2 * $a);
            $x2 = (-$b - sqrt($delta)) / (2 * $a);
            // Arrondir à 2 décimales
            $x1 = round($x1, 2);
            $x2 = round($x2, 2);

            // Séparer le texte et les formules MathJax
            $result = "Les racines sont réelles et distinctes :<br><br>";
            $result .= "<p>$$ x₁ = \\frac{-($b) + \\sqrt{$delta}}{2({$a})} = $x1$$</p><br>";
            $result .= "<p>$$ x₂ = \\frac{-($b) - \\sqrt{$delta}}{2({$a})} = $x2$$</p>";
        } elseif ($delta == 0) {
            $x = -$b / (2 * $a);
            // Arrondir à 2 décimales
            $x = round($x, 2);
            $result = "Les racines sont réelles et identiques :<br><br>";
            $result .= "<p>$$ x = \\frac{-($b)}{2({$a})} = $x $$</p>";
        } else {
            // Racines complexes : arrondir la partie réelle et imaginaire
            $realPart = -$b / (2 * $a);
            $imaginaryPart = sqrt(abs($delta)) / (2 * $a);
            // Arrondir la partie réelle et imaginaire à 2 décimales
            $realPart = round($realPart, 2);
            $imaginaryPart = round($imaginaryPart, 2);
            // Si la partie imaginaire est négative, l'afficher avec un signe -
            $result = "Les racines sont complexes :<br><br>";
            $result .= "<p>$$ x₁ = $realPart + {$imaginaryPart}i $$</p><br>";
            $result .= "<p>$$ x₂ = $realPart - {$imaginaryPart}i $$</p>";
        }
    }
}
?>

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
    <!-- Section pour afficher la formule -->
    <br><br>
    <div style="text-align: center; margin: 20px;">
        <h3>Formule de l'équation quadratique</h3>
        <p id="mathFormula">$$ <?php echo $equation; ?> $$</p>
    </div>

    <!-- Section pour afficher le discriminant -->
    <br><br>
    <div style="text-align: center; margin: 20px;">
        <h3>Calcul du discriminant</h3>
        <p id="discriminantFormula"><?php echo $discriminant; ?></p>
    </div>

    <!-- Chargement de MathJax pour afficher la formule -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/3.2.2/es5/tex-mml-chtml.min.js"></script>

    <script>
        // Force MathJax à traiter uniquement les nouvelles formules sur la page
        MathJax.typeset(); // Rendre les formules mathématiques
    </script>

    <!-- Résultats dans un tableau -->
    <br><br><br>
    <fieldset>
        <legend>Résultat</legend>
        <p><strong><?php echo $discriminant; ?></strong></p>
        <p><strong>Les racines :</strong></p>
        <p id="mathResult"><?php echo   $result; ?></p>
    </fieldset>
<?php else: ?>
    <p>Veuillez soumettre le formulaire pour obtenir les résultats.</p>
<?php endif; ?>

<?php
include("includes/footer.html");
?>
