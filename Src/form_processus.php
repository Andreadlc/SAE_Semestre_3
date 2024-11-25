<?php
include("fonction_moudule_math.php");




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mu = isset($_POST["mu"]) ? floatval($_POST["mu"]) : 0;
    $lambda = isset($_POST["lambda"]) ? floatval($_POST["lambda"]) : 0;
    $t = isset($_POST["t"]) ? floatval($_POST["t"]) : 0;
    $n = isset($_POST["n"]) ? intval($_POST["n"]) : 1;
    $method = isset($_POST["method"]) ? $_POST["method"] : "rectangle";

    $result = calculate_probability($mu, $lambda, $t, $n, $method);
    $mean = $mu;
    $variance = pow($mu, 3) / $lambda;
    $std_dev = sqrt($variance);
}

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
}

$mean = $mu;
$variance = pow($mu, 3) / $lambda;
$std_dev = sqrt($variance);
include("result.php");
?>


