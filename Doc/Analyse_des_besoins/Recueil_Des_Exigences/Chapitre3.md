# III. Les cas d’utilisation

## (a) Acteurs principaux et leurs objectifs généraux

| **Acteur Principal**        | **Objectifs Généraux**                                              |
|-----------------------------|---------------------------------------------------------------------|
| **Administrateur système**   | Suivre les activités de la plateforme via des journaux d’activité.  |
| **Administrateur web**       | Gérer les comptes utilisateurs et l’historique des utilisateurs inscrits. |
| **Utilisateur inscrit**     | Utiliser les modules de calcul et accéder à son historique de calculs. |
| **Visiteur**                 | Consulter les informations générales de la plateforme.             |


## (b) Cas d’utilisation métier (Opérations métiers)

### CUS 1

| **Nom**                      | S’inscrire sur la plateforme               |
|------------------------------|--------------------------------------------|
| **Acteur Principal**         | Visiteur                                  |
| **Portée**                   | Boîte noire                               |
| **Niveau**                   | Utilisateur                               |
| **Description**              | Un visiteur s'inscrit pour devenir utilisateur afin de bénéficier des fonctionnalités du site. |
| **Scénario nominal**         | 1. Accéder à MathMyResult. <br> 2. Aller dans “s’identifier” puis “inscription”. <br> 3. Remplir le formulaire d’inscription. <br> 4. Devenir utilisateur. |
| **Scénario alternatif**      | - Nom d’utilisateur existant. <br> - Mot de passe non conforme. <br> - Échec de vérification Captcha. |


### CUS 2

| **Nom**                      | Accéder aux journaux d’activités         |
|------------------------------|------------------------------------------|
| **Acteur Principal**         | Administrateur système                  |
| **Portée**                   | Boîte noire                             |
| **Niveau**                   | Utilisateur                             |
| **Description**              | L’administrateur système accède aux journaux d’activités. |
| **Scénario nominal**         | 1. Se connecter au compte admin. <br> 2. Accéder aux journaux d’activités. |
| **Scénario alternatif**      | Aucun                                    |



## (c) Cas d’utilisation système (Interactions avec la plateforme)

---

### CUS 1

| **Nom**                      | Accéder au tableau de bord                   |
|------------------------------|----------------------------------------------|
| **Acteur Principal**         | Utilisateur, Administrateur web             |
| **Portée**                   | Boîte noire                                 |
| **Niveau**                   | Sous-fonction                               |
| **Description**              | A partir de la page d’accueil, accéder au tableau de bord. |
| **Scénario nominal**         | 1. Se rendre sur le site MathMyResult. <br> 2. Cliquer sur “Tableau de bord”. |
| **Scénario alternatif**      | Aucun                                       |

---

### CUS 2

| **Nom**                      | Se connecter à la plateforme               |
|------------------------------|--------------------------------------------|
| **Acteur Principal**         | Utilisateur, Administrateur web, Administrateur système |
| **Portée**                   | Boîte noire                               |
| **Niveau**                   | Sous-fonction                             |
| **Description**              | Un utilisateur se connecte pour accéder aux privilèges selon son statut. |
| **Scénario nominal**         | 1. Le visiteur accède au site MathMyResult. <br> 2. Le visiteur se connecte. <br> 3. Une requête vérifie les identifiants dans la base de données. <br> 4. L’utilisateur accède aux fonctionnalités selon son statut. |
| **Scénario alternatif**      | - Nom d’utilisateur existant. <br> - Mot de passe non conforme (par exemple, mot de passe trop court). <br> - Échec de vérification Captcha. |

---



### CUS 3

| **Nom**                      | Regarder la vidéo de présentation         |
|------------------------------|-------------------------------------------|
| **Acteur Principal**         | Visiteur, Utilisateur                    |
| **Portée**                   | Boîte noire                              |
| **Niveau**                   | Sous-fonction                            |
| **Description**              | Un visiteur ou utilisateur regarde la vidéo pour comprendre le site. |
| **Scénario nominal**         | 1. Accéder à MathMyResult. <br> 2. Aller dans “Accueil”. <br> 3. Regarder la vidéo de présentation. |
| **Scénario alternatif**      | Aucun                                    |

---

### CUS 4

| **Nom**                      | Changer son mot de passe                 |
|------------------------------|------------------------------------------|
| **Acteur Principal**         | Utilisateur                             |
| **Portée**                   | Boîte noire                             |
| **Niveau**                   | Sous-fonction                           |
| **Description**              | Un utilisateur souhaite changer son mot de passe. |
| **Scénario nominal**         | 1. Se connecter. <br> 2. Accéder à l’onglet de paramètres (à définir). <br> 3. Entrer l’ancien mot de passe. <br> 4. Entrer et confirmer le nouveau mot de passe. |
| **Scénario alternatif**      | - Nouveau mot de passe non conforme. <br> - Ancien mot de passe incorrect. <br> - La confirmation du mot de passe ne correspond pas. |

---

### CUS 5

| **Nom**                      | Supprimer un compte                     |
|------------------------------|-----------------------------------------|
| **Acteur Principal**         | Administrateur web                     |
| **Portée**                   | Sous-système                           |
| **Niveau**                   | Utilisateur                            |
| **Description**              | Un administrateur web supprime son compte. |
| **Scénario nominal**         | 1. Se connecter. <br> 2. Aller dans “profil”. <br> 3. Supprimer le compte. |
| **Scénario alternatif**      | - L’administrateur oublie son mot de passe. <br> - Le compte ne peut pas être supprimé en raison d'une erreur technique (par exemple, un problème avec la base de données).                                   |

---

### CUS 6

| **Nom**                      | Consultation de la page de présentation |
|------------------------------|-----------------------------------------|
| **Acteur Principal**         | Administrateur système, Administrateur web, Utilisateur, Visiteur |
| **Portée**                   | Boîte noire                            |
| **Niveau**                   | Utilisateur                            |
| **Description**              | Consultation de la page d’accueil par un utilisateur. |
| **Scénario nominal**         | 1. Se connecter. <br> 2. La page d’accueil s’affiche après connexion. |
| **Scénario alternatif**      | Aucun                                   |

---

### CUS 7

| **Nom**                      | Se déconnecter de la plateforme          |
|------------------------------|------------------------------------------|
| **Acteur Principal**         | Administrateur système, Administrateur web, Utilisateur, Visiteur |
| **Portée**                   | Boîte noire                             |
| **Niveau**                   | Utilisateur                             |
| **Description**              | Déconnexion de l’utilisateur de la plateforme. |
| **Scénario nominal**         | 1. Se connecter. <br> 2. Se déconnecter avant de quitter la plateforme. |
| **Scénario alternatif**      | - L’utilisateur n’est pas connecté (un message d’erreur apparaît). <br> - L'utilisateur rencontre un problème lors de la déconnexion (par exemple, perte de connexion).                                   |

---

### CUS 8

| **Nom**                      | Mot de passe oublié                     |
|------------------------------|-----------------------------------------|
| **Acteur Principal**         | Administrateur système, Administrateur web, Utilisateur, Visiteur |
| **Portée**                   | Boîte noire                            |
| **Niveau**                   | Sous-fonction                          |
| **Description**              | Un utilisateur a oublié son mot de passe. |
| **Scénario nominal**         | 1. Aller dans “connexion”. <br> 2. Cliquer sur “mot de passe oublié”. <br> 3. Une page d’aide s’affiche. |
| **Scénario alternatif**      | - Le lien de réinitialisation est invalide ou expiré. <br> - L'utilisateur entre une adresse email incorrecte.                                   |

---

### CUS 9

| **Nom**                      | Se rendre sur la page d’accueil         |
|------------------------------|-----------------------------------------|
| **Acteur Principal**         | Administrateur système, Administrateur web, Utilisateur, Visiteur |
| **Portée**                   | Boîte noire                            |
| **Niveau**                   | Sous-fonction                          |
| **Description**              | Un utilisateur se rend sur la page d’accueil. |
| **Scénario nominal**         | 1. Accéder à MathMyResult. <br> 2. La page d’accueil apparaît automatiquement. |
| **Scénario alternatif**      | Aucun                                   |

---

### CUS 10

| **Nom**                      | Ajouter un utilisateur                   |
|------------------------------|------------------------------------------|
| **Acteur Principal**         | Administrateur web                      |
| **Portée**                   | Boîte blanche                           |
| **Niveau**                   | Objectif utilisateur                    |
| **Description**              | Récupération des données d’un utilisateur et insertion en base de données. |
| **Scénario nominal**         | 1. Récupérer les données de l’utilisateur. <br> 2. Insérer les données dans la base de données. |
| **Scénario alternatif**      | - Problème technique (par exemple, une erreur lors de l'insertion dans la base de données). <br> - Données utilisateur manquantes.                   |

---

### CUS 11

| **Nom**                      | Faire un calcul                          |
|------------------------------|------------------------------------------|
| **Acteur Principal**         | Utilisateur                             |
| **Portée**                   | Boîte noire                             |
| **Niveau**                   | Objectif utilisateur                    |
| **Description**              | Choisir un module de calcul, entrer des variables, et récupérer le résultat. |
| **Scénario nominal**         | 1. Choisir le module de calcul. <br> 2. Entrer les variables. <br> 3. Récupérer le résultat. |
| **Scénario alternatif**      | - Variables non adaptées (par exemple, mauvaise unité). <br> - Variables manquantes (par exemple, un champ obligatoire est vide). |

---

### CUS 12

| **Nom**                      | Ajout d’un module de calcul              |
|------------------------------|------------------------------------------|
| **Acteur Principal**         | Administrateur web                      |
| **Portée**                   | Boîte blanche                           |
| **Niveau**                   | Objectif utilisateur                    |
| **Description**              | Choisir, rédiger le code, et implémenter le module sur le site. |
| **Scénario nominal**         | 1. Choisir le module. <br> 2. Rédiger le code. <br> 3. Implémenter le module sur le site. |
| **Scénario alternatif**      | Aucun                                    |

---

### CUS 13

| **Nom**                      | Modifier un module de calcul             |
|------------------------------|------------------------------------------|
| **Acteur Principal**         | Développeur web                         |
| **Portée**                   | Boîte blanche                           |
| **Niveau**                   | Objectif utilisateur                    |
| **Description**              | Modifier le module et l’ajouter au site. |
| **Scénario nominal**         | 1. Modifier le module. <br> 2. Ajouter le module modifié au site. |
| **Scénario alternatif**      | Aucun                                   |


