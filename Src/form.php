<?php

?>
<form method="post">
    <label for="mu">Espérance (μ) :</label>
    <input type="number" step="any" name="mu" required><br>

    <label for="lambda">Forme (λ) :</label>
    <input type="number" step="any" name="lambda" required><br>

    <label for="t">Valeur t (P(X ≤ t)) :</label>
    <input type="number" step="any" name="t" required><br>

    <label for="n">Nombre de valeurs (n) :</label>
    <input type="number" name="n" min="1" required><br>

    <label for="method">Méthode de calcul :</label>
    <select name="method">
        <option value="rectangle">Méthode des rectangles</option>
        <option value="trapezoidal">Méthode des trapèzes</option>
        <option value="simpson">Méthode de Simpson</option>
    </select><br>

    <input type="submit" value="Calculer">
</form>
