<?php
function rc4($key, $data) {
    $s = range(0, 255);
    $j = 0;
    $key_length = strlen($key);

    $s = range(0, 255); // Initialisation du tableau S avec les valeurs de 0 à 255
    $j = 0; // Initialisation de l'indice j
    $key_length = strlen($key); // Longueur de la clé
    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $s[$i] + ord($key[$i % $key_length])) % 256; // Calcul de j en fonction de la clé
        $temp = $s[$i]; // Temporaire pour l'échange
        $s[$i] = $s[$j]; // Échange des valeurs
        $s[$j] = $temp; // Échange des valeurs
    }


    $i = $j = 0; // Initialisation des indices i et j
    $result = ''; // Variable pour stocker le texte final
    for ($c = 0, $n = strlen($data); $c < $n; $c++) {
        $i = ($i + 1) % 256; // Incrémentation circulaire de i
        $j = ($j + $s[$i]) % 256; // Calcul de j en fonction de S
        $temp = $s[$i]; // Temporaire pour l'échange
        $s[$i] = $s[$j]; // Échange des valeurs dans le tableau S
        $s[$j] = $temp; // Échange des valeurs dans le tableau S
        $k = $s[($s[$i] + $s[$j]) % 256]; // La clé générée à chaque itération
        $result .= chr(ord($data[$c]) ^ $k); // XOR entre le texte et la clé générée
    }

}
?>
