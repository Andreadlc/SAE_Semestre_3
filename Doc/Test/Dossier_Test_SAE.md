# SAE - Semestre 4 - Dossier de tests 

## DELCROS Andrea  
## FRANCILLETTE Thomas 
## EUGENE Clément 
## MENDY Dorian

### INF2-FI- B – 2024-2025

---

## **1- INTRODUCTION**

Ce rapport présente les résultats des tests boîte blanche réalisés dans le cadre du projet **Math My Result**. L'objectif principal de ce projet est de développer une application fiable et performante en validant minutieusement toutes ses fonctionnalités via des tests unitaires qui explorent la logique interne du code.

Les tests boîte blanche utilisés ici permettent d'évaluer précisément le comportement interne des différentes fonctions et modules, en examinant les chemins d'exécution et les conditions logiques. Cette approche garantit que le logiciel répond aux spécifications attendues et assure une robustesse optimale dans divers contextes d'utilisation.

---

## **2- ELABORATION DES TESTS BOITES BLANCHES**

Les tests boîte blanche reposent sur l'analyse directe du code source. Ils permettent de vérifier la couverture des différentes branches logiques et de s'assurer que chaque fonction se comporte comme prévu. Dans ce dossier, nous présentons les tests pour trois modules essentiels :  
1. **Accès aux journaux**  
2. **Authentification**  
3. **Inscription et chiffrement**

---

## **3- TESTS DU MODULE D'ACCÈS AUX JOURNAUX**

### **Tableau 1 - Conception des Tests pour `Acces_aux_journauxTest` (Boîte Blanche)**

| Cas de test                      | Conditions initiales                                | Action effectuée                        | Résultat attendu                                          |
| -------------------------------- | --------------------------------------------------- | --------------------------------------- | --------------------------------------------------------- |
| P1 : Accès aux logs par admin    | Session simulée avec `user_logged_in=true`, rôle=2   | Vérifier l'existence et le contenu du fichier log | Le fichier de logs existe et contient des entrées        |
| P2 : Tentative de connexion échouée | Variable `i` >= 3 dans la session                   | Comparer `i` et générer un message d'erreur          | Message d'erreur indiquant le dépassement du nombre maximal |

### **Tableau 2 - Données de test pour `Acces_aux_journauxTest`**

| Cas de test | Valeurs simulées                                           | Sortie attendue                                                      |
| ----------- | ---------------------------------------------------------- | -------------------------------------------------------------------- |
| P1          | `$_SESSION['user_logged_in']=true`, `role=2`, `username='admin_system'`<br>Dossier et fichier log créés et remplis | Fichier log existant et non vide (contenu non nul)                    |
| P2          | `$_SESSION['i']=3`                                          | `$_SESSION['error_message'] = "Vous avez dépassé le nombre maximal de tentatives. Veuillez réessayer plus tard."` |

---

## **4- TESTS DU MODULE D'AUTHENTIFICATION**

### **Tableau 1 - Conception des Tests pour `AuthServiceTest` (Boîte Blanche)**

| Cas de test                          | Conditions initiales et entrées                  | Action effectuée                             | Résultat attendu                                                              |
| ------------------------------------ | ------------------------------------------------ | -------------------------------------------- | ----------------------------------------------------------------------------- |
| P1 : Attribution du nom en session   | `$_POST['username']='testUser'`, captcha correct   | Affecter `username` en session et connecter   | `$_SESSION['username'] == 'testUser'` et `$_SESSION['user_logged_in'] == true`  |
| P2 : Tentative de connexion sans nom   | `$_POST['username']=''`                           | Vérifier absence de nom et générer message d'erreur | `$_SESSION['error_message'] == "Nom d'utilisateur manquant"`                   |
| P3 : Nettoyage de session             | Session contenant `username` et `user_logged_in`  | Détruire la session et la redémarrer          | `$_SESSION` vide après destruction                                            |
| P4 : Mot de passe incorrect           | `$_POST['username']='john.doe'`, `password='wrongpassword'`, captcha correct | Simuler connexion avec mauvais mot de passe   | `$_SESSION['error_message'] == "Mot de passe incorrect"` et connexion refusée   |
| P5 : Utilisateur inexistant           | `$_POST['username']='nonexistentUser'`, `password='password123'`, captcha correct | Vérifier existence de l'utilisateur           | `$_SESSION['error_message'] == "Utilisateur non trouvé"`                      |
| P6 : Mot de passe vide                | `$_POST['username']='john.doe'`, `password=''`, captcha correct | Tester connexion avec mot de passe vide       | `$_SESSION['error_message'] == "Mot de passe manquant"` et connexion refusée    |
| P7 : Captcha incorrect                | `$_POST['username']='john.doe'`, `password='password123'`, captcha faux | Vérifier validation captcha                   | `$_SESSION['error_message'] == "Captcha incorrect"`                           |

### **Tableau 2 - Données de test pour `AuthServiceTest`**

| Cas de test | Valeurs simulées                                                                                                                       | Sortie attendue                                                          |
| ----------- | -------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------ |
| P1          | `$_POST['username']='testUser'`, `$_SESSION["code"]='correct_captcha'`                                                                 | Session contient `'testUser'` et `user_logged_in == true`                |
| P2          | `$_POST['username']=''`                                                                                                                | `$_SESSION['error_message'] == "Nom d'utilisateur manquant"`             |
| P3          | Session initialisée avec `username='tempUser'` et `user_logged_in==true`, puis destruction de session                                   | Session vide                                                             |
| P4          | `$_POST['username']='john.doe'`, `$_POST['password']='wrongpassword'`, captcha correct                                                  | `$_SESSION['error_message'] == "Mot de passe incorrect"` et `user_logged_in == false` |
| P5          | `$_POST['username']='nonexistentUser'`, `$_POST['password']='password123'`, captcha correct                                             | `$_SESSION['error_message'] == "Utilisateur non trouvé"`                 |
| P6          | `$_POST['username']='john.doe'`, `$_POST['password']=''`, captcha correct                                                                | `$_SESSION['error_message'] == "Mot de passe manquant"`                   |
| P7          | `$_POST['username']='john.doe'`, `$_POST['password']='password123'`, `$_SESSION["code"]='incorrect_captcha'`                              | `$_SESSION['error_message'] == "Captcha incorrect"`                      |

---

## **5- TESTS DU MODULE D'INSCRIPTION & CRYPTOGRAPHIE**

### **Tableau 1 - Conception des Tests pour `InscriptionTest` (Boîte Blanche)**

| Cas de test                          | Conditions et entrées                   | Action effectuée                             | Résultat attendu                                           |
| ------------------------------------ | --------------------------------------- | -------------------------------------------- | ---------------------------------------------------------- |
| P1 : Nom d'utilisateur valide        | Chaîne alphanumérique conforme          | Vérifier format via expression régulière      | Retourne TRUE                                             |
| P2 : Nom d'utilisateur invalide       | Chaîne avec caractères spéciaux         | Vérifier format via expression régulière      | Retourne FALSE                                            |
| P3 : Mot de passe valide               | Chaîne d'au moins 8 caractères           | Vérifier longueur du mot de passe             | Retourne TRUE                                             |
| P4 : Mot de passe invalide             | Chaîne trop courte                        | Vérifier longueur du mot de passe             | Retourne FALSE                                            |
| P5 : Chiffrement RC4                   | Clé et mot de passe fournis               | Chiffrer le mot de passe avec RC4             | Texte chiffré différent du mot de passe en clair          |
| P6 : Captcha valide                    | Code en session et saisie identique       | Comparer saisie et code en session            | Retourne TRUE                                             |
| P7 : Captcha invalide                  | Code en session et saisie différentes     | Comparer saisie et code en session            | Retourne FALSE                                            |

### **Tableau 2 - Données de test pour `InscriptionTest`**

| Cas de test | Entrée / Valeur                              | Sortie attendue                                               |
| ----------- | -------------------------------------------- | ------------------------------------------------------------- |
| P1          | Nom utilisateur : "johnDoe123"               | TRUE (format valide)                                            |
| P2          | Nom utilisateur : "john!@#"                   | FALSE (format invalide)                                           |
| P3          | Mot de passe : "password123"                  | TRUE (longueur ≥ 8)                                              |
| P4          | Mot de passe : "pass"                         | FALSE (longueur < 8)                                              |
| P5          | Clé : "MaCleSecreteRC4", Mot de passe : "password123" | Texte chiffré ≠ "password123" (résultat via RC4)                 |
| P6          | Captcha : Code en session "1234", saisie "1234"     | TRUE                                                           |
| P7          | Captcha : Code en session "1234", saisie "5678"     | FALSE                                                          |

---

> **Remarque :**  
> Ces tableaux présentent la conception et les données de test basées sur une approche boîte blanche. Ils permettent d'évaluer le comportement interne de l'application **Math My Result** via des tests unitaires ciblés sur la logique de chaque module.

---

Ce dossier de tests permet de vérifier la robustesse des modules critiques de **Math My Result** (gestion des journaux, authentification et inscription/chiffrement) et assure ainsi une meilleure couverture du code et une fiabilité accrue de l'application.
