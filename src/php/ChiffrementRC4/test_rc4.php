<?php
/**************************/
/* Début du script RC4    */
/**************************/
include("rc4.php"); // Inclusion du module RC4 pour le chiffrement/déchiffrement

/**************************/
/* Liste des tests        */
/**************************/
$tests = [
    ["Key", "Plaintext"], // Test 1 : Clé 'Key' et texte 'Plaintext'
    ["Wiki", "pedia"],    // Test 2 : Clé 'Wiki' et texte 'pedia'
    ["Secret", "Attack at dawn"] // Test 3 : Clé 'Secret' et texte 'Attack at dawn'
];

/**************************/
/* Ouverture du fichier   */
/**************************/
$file = fopen("passwords.txt", "w"); // Ouvre le fichier en mode écriture

/**************************/
/* Début du traitement    */
/**************************/
echo "<pre>";  // Utilisation de la balise <pre> pour préserver les espaces et retours à la ligne

foreach ($tests as $test) {
    $cle = $test[0]; // Clé de chiffrement
    $texte = $test[1]; // Texte à chiffrer

    /**************************/
    /* Chiffrement du texte   */
    /**************************/
    // Appliquer le chiffrement RC4 avec la clé et le texte
    $texte_chiffre = strtoupper(bin2hex(rc4($cle, $texte))); // Convertir en hex en majuscules pour la sortie

    /**************************/
    /* Déchiffrement du texte */
    /**************************/
    // Déchiffrement du texte chiffré en utilisant la même clé
    $texte_dechiffre = rc4($cle, hex2bin($texte_chiffre)); // Déchiffrement en retournant le texte original

    /**************************/
    /* Écriture dans le fichier */
    /**************************/
    // Ajouter une séparation claire dans le fichier de sortie
    fwrite($file, "-----------------------------------------------\n");
    fwrite($file, "Clé : $cle\n");
    fwrite($file, "Texte : $texte\n");
    fwrite($file, "Texte Chiffré : $texte_chiffre\n");
    fwrite($file, "Texte Déchiffré : $texte_dechiffre\n");
    fwrite($file, "-----------------------------------------------\n\n");


}

/**************************/
/* Fermeture du fichier   */
/**************************/
fclose($file); // Fermer le fichier après l'écriture

/**************************/
/* Lecture du fichier     */
/**************************/
$file = fopen("passwords.txt", "r"); // Ouvrir le fichier en mode lecture
while ($line = fgets($file)) {
    echo $line; // Afficher chaque ligne du fichier dans la page web
    echo "<br>";   // Ajouter un saut de ligne HTML entre chaque ligne du fichier
}
fclose($file); // Fermer le fichier après la lecture

/**************************/
/* Fin du script RC4      */
/**************************/
echo "</pre>";  // Fin du bloc <pre>
?>
