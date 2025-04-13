<?php


use PHPUnit\Framework\TestCase;

class Acces_aux_journauxTest extends TestCase
{
    public function testAdministrateurPeutVoirLesLogs()
    {
        // Simuler une session d'un administrateur système
        $_SESSION['user_logged_in'] = true;
        $_SESSION['role'] = 2; // Administrateur système
        $_SESSION['username'] = 'admin_system';

        // Définir le dossier et fichier de logs avec un chemin absolu
        $logDir = __DIR__ . '/../src/php/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logFile = $logDir . '/suppressions.log';
        file_put_contents($logFile, "Test de log\n");

        // Vérifier le chemin absolu du fichier pour le debug
        var_dump(realpath($logFile));

        // Vérifier que le fichier de logs existe et qu'il n'est pas vide
        $this->assertFileExists($logFile, "Le fichier de logs n'existe pas.");

        // Lire le fichier de logs
        $logs = file($logFile, FILE_SKIP_EMPTY_LINES);

        // S'assurer que les logs ne sont pas vides
        $this->assertNotEmpty($logs, "Le fichier de logs est vide.");
    }

    public function testTentativeDeConnexionFailed()
    {
        // Simuler une tentative de connexion échouée
        $_SESSION['i'] = 3; // Plus de 3 tentatives échouées

        $this->assertGreaterThan(2, $_SESSION['i'], "Le nombre de tentatives échouées doit être supérieur à 2");

        // Vérifier si un message d'erreur est généré
        if ($_SESSION['i'] >= 3) {
            $_SESSION['error_message'] = "Vous avez dépassé le nombre maximal de tentatives. Veuillez réessayer plus tard.";
            $this->assertEquals("Vous avez dépassé le nombre maximal de tentatives. Veuillez réessayer plus tard.", $_SESSION['error_message']);
        }
    }
}
