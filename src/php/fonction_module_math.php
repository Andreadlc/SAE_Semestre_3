<?php



// Fonction de densité de la loi inverse-gaussienne
function inverse_gaussian_pdf($x, $mu, $lambda) {
    if ($x <= 0 || $mu <= 0 || $lambda <= 0) {
        return 0;
    }
    return sqrt($lambda / (2 * M_PI * pow($x, 3))) * exp(-$lambda * pow($x - $mu, 2) / (2 * pow($mu, 2) * $x));
}


// Méthode des rectangles gauches pour l'intégration numérique
function rectangle_method($a, $b, $n, $mu, $lambda) {
    $h = ($b - $a) / $n;
    $sum = 0;
    for ($i = 0; $i < $n; $i++) {
        $x = $a + $i * $h;
        $sum += inverse_gaussian_pdf($x, $mu, $lambda);
    }
    return $h * $sum;
}


// Méthode des trapèzes pour l'intégration numérique
function trapezoidal_method($a, $b, $n, $mu, $lambda) {
    $h = ($b - $a) / $n;
    $sum = (inverse_gaussian_pdf($a, $mu, $lambda) + inverse_gaussian_pdf($b, $mu, $lambda)) / 2;
    for ($i = 1; $i < $n; $i++) {
        $x = $a + $i * $h;
        $sum += inverse_gaussian_pdf($x, $mu, $lambda);
    }
    return $h * $sum;
}


// Méthode de Simpson pour l'intégration numérique
function simpson_method($a, $b, $n, $mu, $lambda) {
    if ($n % 2 != 0) {
        return "Erreur : n doit être pair pour la méthode de Simpson";
    }

    $h = ($b - $a) / $n;
    $sum = inverse_gaussian_pdf($a, $mu, $lambda) + inverse_gaussian_pdf($b, $mu, $lambda);
    for ($i = 1; $i < $n; $i += 2) {
        $x = $a + $i * $h;
        $sum += 4 * inverse_gaussian_pdf($x, $mu, $lambda);
    }
    for ($i = 2; $i < $n - 1; $i += 2) {
        $x = $a + $i * $h;
        $sum += 2 * inverse_gaussian_pdf($x, $mu, $lambda);
    }
    return $h * $sum / 3;
}

