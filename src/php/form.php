<?php
echo "<br><br><br>";
?>

<fieldset>
    <legend><h3>Calculateur de probabilité - Loi inverse-gaussienne</h3></legend>
    <form method="post" onsubmit="return validateForm()">
        <label for="mu">Espérance (μ) :</label>
        <input type="number" step="any" name="mu" id="mu" required min="1"><br>

        <label for="lambda">Forme (λ) :</label>
        <input type="number" step="any" name="lambda" id="lambda" required min="1"><br>

        <label for="t">Valeur t (P(X ≤ t)) :</label>
        <input type="number" step="any" name="t" id="t" required min="1"><br>

        <label for="n">Nombre de valeurs (n) :</label>
        <input type="number" name="n" id="n" min="2" required><br>

        <label for="method">Méthode de calcul :</label>
        <select name="method" id="method">
            <option value="rectangle">Méthode des rectangles</option>
            <option value="trapezoidal">Méthode des trapèzes</option>
            <option value="simpson">Méthode de Simpson</option>
        </select><br>

        <input type="submit" value="Calculer">
    </form>
</fieldset>


