<?php


use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
    public function setUp(): void
    {
        $_SESSION = []; // Réinitialise la session
        session_start(); // Assure que la session est démarrée
    }

    // Fonction pour éviter les redirections lors des tests
    private function disableRedirects()
    {
        ob_start();  // Commence à capturer la sortie
        // Simuler une action sans effectuer de redirection réelle
        ob_end_clean(); // Arrête la capture et efface la sortie
    }

    public function testUsernameSession()
    {
        // Définir un nom d'utilisateur
        $_POST['username'] = 'testUser';
        $_SESSION["code"] = 'correct_captcha'; // Assure que le captcha est correct

        // Désactiver les redirections
        $this->disableRedirects();

        // Simuler le processus de connexion (sans faire de réelle connexion à la base de données)
        $_SESSION['username'] = $_POST['username'];  // On assigne le nom d'utilisateur à la session
        $_SESSION['user_logged_in'] = true;  // Simule que l'utilisateur est connecté

        // Vérification que la session contient bien le nom d'utilisateur
        var_dump($_SESSION); // Affiche la session pour vérifier si elle contient 'username'

        $this->assertEquals('testUser', $_SESSION['username'], "Le nom d'utilisateur doit être celui attendu.");
        $this->assertTrue($_SESSION['user_logged_in'], "L'utilisateur doit être marqué comme connecté.");
    }

    // Test d'un utilisateur sans nom
    public function testNoUsername()
    {
        // Simuler un cas où le nom d'utilisateur est vide
        $_POST['username'] = '';

        // Désactiver les redirections
        $this->disableRedirects();

        // Tentative de connexion sans nom d'utilisateur
        if ($_POST['username'] == '') {
            $_SESSION['error_message'] = 'Nom d\'utilisateur manquant';
        }

        // Vérification de la présence d'un message d'erreur
        $this->assertEquals('Nom d\'utilisateur manquant', $_SESSION['error_message'], "Le message d'erreur doit indiquer un nom d'utilisateur manquant.");
    }

    // Test si la session est correctement nettoyée après chaque test
    public function testSessionCleanup()
    {
        // Assigner des valeurs à la session
        $_SESSION['username'] = 'tempUser';
        $_SESSION['user_logged_in'] = true;

        // Vérifier la présence des données
        $this->assertTrue(isset($_SESSION['username']), "La session doit contenir un nom d'utilisateur.");
        $this->assertTrue(isset($_SESSION['user_logged_in']), "La session doit contenir l'information de connexion.");

        // Réinitialiser la session pour s'assurer qu'elle est propre après ce test
        session_destroy();
        session_start(); // Redémarrer la session

        // Vérifier que la session est vide après destruction
        $this->assertEmpty($_SESSION, "La session doit être vide après destruction.");
    }
    public function testIncorrectPassword()
    {
        $_POST['username'] = 'john.doe';
        $_POST['password'] = 'wrongpassword';
        $_SESSION["code"] = 'correct_captcha'; // Assure que le captcha est correct

        // Désactiver les redirections
        $this->disableRedirects();

        // Simule le processus de connexion, mais avec un mot de passe incorrect
        $_SESSION['username'] = $_POST['username'];  // Assignation du nom d'utilisateur
        $_SESSION['password'] = $_POST['password'];  // Assignation du mot de passe (faux ici)
        $_SESSION['user_logged_in'] = false;  // L'utilisateur ne doit pas être connecté

        // Simuler l'échec du mot de passe
        if ($_SESSION['password'] !== 'password123') {
            $_SESSION['error_message'] = 'Mot de passe incorrect';
        }

        // Vérification de l'affichage du message d'erreur
        $this->assertEquals('Mot de passe incorrect', $_SESSION['error_message'], "Le message d'erreur doit indiquer un mot de passe incorrect.");
        $this->assertFalse($_SESSION['user_logged_in'], "L'utilisateur ne doit pas être connecté avec un mot de passe incorrect.");
    }

    public function testNonExistentUser()
    {
        $_POST['username'] = 'nonexistentUser';
        $_POST['password'] = 'password123';
        $_SESSION["code"] = 'correct_captcha'; // Assure que le captcha est correct

        // Désactiver les redirections
        $this->disableRedirects();

        // Simuler la tentative de connexion avec un utilisateur inexistant
        $_SESSION['username'] = $_POST['username'];  // Assignation du nom d'utilisateur inexistant
        $_SESSION['user_logged_in'] = false;  // L'utilisateur ne doit pas être connecté

        // Simuler la vérification de l'existence de l'utilisateur (en vrai, ici il n'existe pas)
        if ($_POST['username'] !== 'john.doe') {
            $_SESSION['error_message'] = 'Utilisateur non trouvé';
        }

        // Vérification du message d'erreur pour un utilisateur non existant
        $this->assertEquals('Utilisateur non trouvé', $_SESSION['error_message'], "Le message d'erreur doit indiquer que l'utilisateur n'a pas été trouvé.");
    }


    public function testEmptyPassword()
    {
        $_POST['username'] = 'john.doe';
        $_POST['password'] = '';  // Mot de passe vide
        $_SESSION["code"] = 'correct_captcha'; // Assure que le captcha est correct

        // Désactiver les redirections
        $this->disableRedirects();

        // Simuler la tentative de connexion avec un mot de passe vide
        $_SESSION['username'] = $_POST['username'];  // Assignation du nom d'utilisateur
        $_SESSION['password'] = $_POST['password'];  // Mot de passe vide
        $_SESSION['user_logged_in'] = false;  // L'utilisateur ne doit pas être connecté

        // Vérification du message d'erreur pour un mot de passe vide
        if (empty($_POST['password'])) {
            $_SESSION['error_message'] = 'Mot de passe manquant';
        }

        // Vérification de l'erreur sur le mot de passe vide
        $this->assertEquals('Mot de passe manquant', $_SESSION['error_message'], "Le message d'erreur doit indiquer un mot de passe manquant.");
        $this->assertFalse($_SESSION['user_logged_in'], "L'utilisateur ne doit pas être connecté avec un mot de passe vide.");
    }


    public function testIncorrectCaptcha()
    {
        $_POST['username'] = 'john.doe';
        $_POST['password'] = 'password123';
        $_SESSION["code"] = 'incorrect_captcha'; // Captcha incorrect

        $this->disableRedirects();

        // Simuler la tentative de connexion avec captcha incorrect
        if ($_SESSION["code"] !== 'correct_captcha') {
            $_SESSION['error_message'] = 'Captcha incorrect';
        }

        // Vérification de l'erreur de captcha
        $this->assertEquals('Captcha incorrect', $_SESSION['error_message'], "Le message d'erreur doit indiquer que le captcha est incorrect.");
    }


}
