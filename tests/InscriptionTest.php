<?php


use PHPUnit\Framework\TestCase;
// Assure-toi que le chemin est correct ici
include_once __DIR__ . '/../src/php/ChiffrementRC4/rc4.php'; // Mise à jour du chemin d'inclusion


class InscriptionTest extends TestCase
{
    public function testValidUsername()
    {
        // Cas où le nom d'utilisateur est valide
        $validUsername = "johnDoe123";
        $this->assertTrue(preg_match('/^[A-Za-z0-9]{5,}$/', $validUsername) === 1);

        // Cas où le nom d'utilisateur est invalide
        $invalidUsername = "john!@#"; // Contient des caractères spéciaux
        $this->assertFalse(preg_match('/^[A-Za-z0-9]{5,}$/', $invalidUsername) === 1);
    }

    public function testValidPassword()
    {
        // Mot de passe valide
        $password = "password123";
        $this->assertTrue(strlen($password) >= 8);

        // Mot de passe invalide
        $shortPassword = "pass";
        $this->assertFalse(strlen($shortPassword) >= 8);
    }

    public function testRc4Encryption()
    {
        $key = "MaCleSecreteRC4";
        $password = "password123";

        // Chiffre le mot de passe
        $encryptedPassword = bin2hex(rc4($key, $password));

        // Vérifie que le mot de passe chiffré n'est pas égal au mot de passe en clair
        $this->assertNotEquals($encryptedPassword, $password);
    }





    public function testValidCaptcha()
    {
        // Cas où le captcha est correct
        $_SESSION['code'] = '1234'; // Le code du captcha dans la session
        $captchaInput = '1234';
        $this->assertTrue($captchaInput === $_SESSION['code']);

        // Cas où le captcha est incorrect
        $captchaInput = '5678';
        $this->assertFalse($captchaInput === $_SESSION['code']);
    }
}