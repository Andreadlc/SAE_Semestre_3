<?php
include("fonction_module_math.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $mu = isset($_POST["mu"]) ? floatval($_POST["mu"]) : 0;
    $lambda = isset($_POST["lambda"]) ? floatval($_POST["lambda"]) : 0;
    $t = isset($_POST["t"]) ? floatval($_POST["t"]) : 0;
    $n = isset($_POST["n"]) ? intval($_POST["n"]) : 1;
    $method = isset($_POST["method"]) ? $_POST["method"] : "rectangle";


    // Calcul des résultats
    switch ($method) {
        case 'rectangle':
            $result = rectangle_method(0, $t, $n, $mu, $lambda);
            break;
        case 'trapezoidal':
            $result = trapezoidal_method(0, $t, $n, $mu, $lambda);
            break;
        case 'simpson':
            $result = simpson_method(0, $t, $n, $mu, $lambda);
            break;
        default:
            $result = "Méthode non reconnue";
            break;
    }

    // Calcul des paramètres statistiques
    $mean = $mu;
    $variance = pow($mu, 3) / $lambda; // Calcul de la variance
    $std_dev = sqrt($variance); // Calcul de l'écart-type

}

include("js/result.php");
?>
