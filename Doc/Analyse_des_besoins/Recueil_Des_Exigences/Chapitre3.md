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
|**Précondition**             | - Le visiteur doit être sur la page d'inscription et avoir un accès fonctionnel à Internet.<br> - Le visiteur doit remplir tous les champs obligatoires du formulaire d'inscription.|
|**Garantie minimale**|- Le formulaire d'inscription doit valider la présence des champs obligatoires (nom, prénom, mot de passe, captcha). <br> - Le compte utilisateur est créé dans la base de données.|
|**Garantie maximale**|- L'utilisateur reçoit un message de confirmation après l'inscription (bien que la plateforme ne prévoie pas d'email, la page de confirmation sur le site peut être affichée). <br>- Le visiteur est redirigé vers une page de connexion après l'inscription avec ses identifiants pré-remplis.|
| **Scénario nominal**         | 1. Accéder à MathMyResult. <br> 2. Aller dans “s’identifier” puis “inscription”. <br> 3. Remplir le formulaire d’inscription. <br> 4. Devenir utilisateur. |
| **Scénario alternatif**      | - Nom d’utilisateur existant. <br> - Mot de passe non conforme. <br> - Échec de vérification Captcha. |



### CUS 2

| **Nom**                      | Accéder aux journaux d’activités               |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Administrateur système                        |
| **Portée**                   | Boîte noire                                   |
| **Niveau**                   | Utilisateur                                   |
| **Description**              | L’administrateur système accède aux journaux d’activités. |
| **Précondition**             | - L'administrateur système doit être connecté à son compte avec les identifiants fournis (login : `sysadmin`, mdp : `sysadmin`).<br> - Les journaux d'activité doivent exister et être accessibles dans le système. |
| **Garantie minimale**        | - L'administrateur système peut voir les journaux d'activités sous forme brute. |
| **Garantie maximale**        | - L'administrateur peut rechercher des logs par période, utilisateur, ou type d'activité spécifique.<br> - Les journaux sont triés et filtrables pour une meilleure gestion des informations. |
| **Scénario nominal**         | 1. Se connecter au compte admin.<br> 2. Accéder aux journaux d’activités. |
| **Scénario alternatif**      | Aucun |



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

| **Nom**                      | Regarder la vidéo de présentation               |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Visiteur, Utilisateur                         |
| **Portée**                   | Boîte noire                                   |
| **Niveau**                   | Sous-fonction                                  |
| **Description**              | Un visiteur ou utilisateur regarde la vidéo pour comprendre le site. |
| **Précondition**             | - La vidéo doit être disponible sur la plateforme à une URL accessible.<br> - Le visiteur ou l'utilisateur doit être connecté ou en mode visiteur. |
| **Garantie minimale**        | - La vidéo doit pouvoir être lancée sans erreur, avec une qualité de lecture acceptable. |
| **Garantie maximale**        | - L'utilisateur peut ajuster la qualité de la vidéo (par exemple, basse, moyenne, haute qualité) selon sa connexion.<br> - La vidéo inclut des sous-titres ou une autre forme d'aide visuelle pour les personnes malentendantes. |
| **Scénario nominal**         | 1. Accéder à MathMyResult.<br> 2. Aller dans “Accueil”.<br> 3. Regarder la vidéo de présentation. |
| **Scénario alternatif**      | Aucun |


---

### CUS 4

| **Nom**                      | Changer son mot de passe                       |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Utilisateur                                   |
| **Portée**                   | Boîte noire                                   |
| **Niveau**                   | Sous-fonction                                  |
| **Description**              | Un utilisateur souhaite changer son mot de passe. |
| **Précondition**             | - L'utilisateur doit être connecté à son compte.<br> - L'utilisateur connaît son ancien mot de passe pour le changement. |
| **Garantie minimale**        | - Le nouveau mot de passe doit respecter les critères de sécurité définis (par exemple, longueur minimale, inclusion de caractères spéciaux).<br> - L'utilisateur est redirigé vers la page de connexion après un changement réussi. |
| **Garantie maximale**        | - L'utilisateur reçoit une notification de confirmation (sur le site) que son mot de passe a été modifié avec succès.<br> - Le mot de passe est crypté de manière sécurisée dans la base de données. |
| **Scénario nominal**         | 1. Se connecter.<br> 2. Accéder à l’onglet de paramètres (à définir).<br> 3. Entrer l’ancien mot de passe.<br> 4. Entrer et confirmer le nouveau mot de passe. |
| **Scénario alternatif**      | - Nouveau mot de passe non conforme.<br> - Ancien mot de passe incorrect.<br> - La confirmation du mot de passe ne correspond pas. |


---

### CUS 5

| **Nom**                      | Supprimer un compte                           |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Administrateur web                            |
| **Portée**                   | Sous-système                                   |
| **Niveau**                   | Utilisateur                                   |
| **Description**              | Un administrateur web supprime son compte.    |
| **Précondition**             | - L'administrateur web doit être connecté à son compte.<br> - L'administrateur web doit être en mesure de sélectionner le compte à supprimer dans la base de données. |
| **Garantie minimale**        | - L'administrateur web peut supprimer le compte de l'utilisateur sélectionné avec succès.<br> - L'historique de l'utilisateur et les logs associés sont également supprimés. |
| **Garantie maximale**        | - L'administrateur peut supprimer plusieurs comptes d'utilisateurs en batch à partir d'un fichier CSV.<br> - Une confirmation claire et un message d'alerte sont affichés avant de procéder à la suppression définitive. |
| **Scénario nominal**         | 1. Se connecter.<br> 2. Aller dans “profil”.<br> 3. Supprimer le compte. |
| **Scénario alternatif**      | - L’administrateur oublie son mot de passe.<br> - Le compte ne peut pas être supprimé en raison d'une erreur technique (par exemple, un problème avec la base de données). |


---

### CUS 6

| **Nom**                      | Consultation de la page de présentation        |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Administrateur système, Administrateur web, Utilisateur, Visiteur |
| **Portée**                   | Boîte noire                                   |
| **Niveau**                   | Utilisateur                                   |
| **Description**              | Consultation de la page d’accueil par un utilisateur. |
| **Précondition**             | - L'utilisateur ou visiteur doit être connecté ou non.<br> - La page d'accueil doit être active et fonctionnelle. |
| **Garantie minimale**        | - La page d'accueil s'affiche correctement, avec les informations de présentation et la vidéo.<br> - Les liens de navigation sont fonctionnels. |
| **Garantie maximale**        | - La page d'accueil s'adapte en fonction de la taille de l'écran de l'utilisateur (responsive design).<br> - Les informations sont dynamiques, mises à jour régulièrement et permettent de guider l'utilisateur vers les modules de calcul. |
| **Scénario nominal**         | 1. Se connecter.<br> 2. La page d’accueil s’affiche après connexion. |
| **Scénario alternatif**      | Aucun |

---

### CUS 7

| **Nom**                      | Se déconnecter de la plateforme                |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Administrateur système, Administrateur web, Utilisateur, Visiteur |
| **Portée**                   | Boîte noire                                   |
| **Niveau**                   | Utilisateur                                   |
| **Description**              | Déconnexion de l’utilisateur de la plateforme. |
| **Précondition**             | - L'utilisateur ou administrateur doit être connecté à la plateforme. |
| **Garantie minimale**        | - L'utilisateur est déconnecté de la plateforme, et l'accès aux ressources protégées est bloqué. |
| **Garantie maximale**        | - Une page de confirmation s'affiche pour vérifier que l'utilisateur souhaite bien se déconnecter.<br> - L'utilisateur est redirigé vers la page d'accueil après la déconnexion. |
| **Scénario nominal**         | 1. Se connecter.<br> 2. Se déconnecter avant de quitter le site. |
| **Scénario alternatif**      | Aucun |

---

### CUS 8

| **Nom**                      | Mot de passe oublié                          |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Utilisateur                                   |
| **Portée**                   | Boîte noire                                   |
| **Niveau**                   | Utilisateur                                   |
| **Description**              | Un utilisateur réinitialise son mot de passe en cas d'oubli. |
| **Précondition**             | - L'utilisateur doit être sur la page de connexion et avoir accès à l'option "mot de passe oublié". |
| **Garantie minimale**        | - L'option "mot de passe oublié" mène à une page expliquant la procédure de réinitialisation.<br> - Un message d'erreur est affiché si un utilisateur tente de réinitialiser le mot de passe sans fournir un identifiant valide. |
| **Garantie maximale**        | - L'utilisateur reçoit un email de réinitialisation du mot de passe (à définir si nécessaire dans une version future du projet).<br> - La page d'aide présente un processus complet et intuitif pour récupérer ou réinitialiser le mot de passe. |
| **Scénario nominal**         | 1. Aller à la page de connexion.<br> 2. Cliquer sur "Mot de passe oublié".<br> 3. Suivre la procédure pour réinitialiser le mot de passe. |
| **Scénario alternatif**      | - Aucun |

---

### CUS 9

| **Nom**                      | Se rendre sur la page d’accueil               |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Visiteur, Utilisateur                         |
| **Portée**                   | Boîte noire                                   |
| **Niveau**                   | Utilisateur                                   |
| **Description**              | L'utilisateur ou visiteur accède à la page d'accueil de la plateforme. |
| **Précondition**             | - L'utilisateur ou visiteur doit avoir accès à Internet et connaître l'URL de la plateforme. |
| **Garantie minimale**        | - La page d'accueil s'affiche correctement à l'accès de la plateforme. |
| **Garantie maximale**        | - La page d'accueil se charge rapidement (moins de 3 secondes).<br> - La page d'accueil est sécurisée (HTTPS) et n'affiche pas de message d'erreur. |
| **Scénario nominal**         | 1. Ouvrir le navigateur.<br> 2. Accéder à l'URL du site.<br> 3. La page d'accueil s'affiche. |
| **Scénario alternatif**      | - Aucun |

---

### CUS 10

| **Nom**                      | Ajouter un utilisateur                       |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Administrateur web                            |
| **Portée**                   | Boîte noire                                   |
| **Niveau**                   | Administrateur                                |
| **Description**              | L'administrateur web ajoute un ou plusieurs utilisateurs à la plateforme. |
| **Précondition**             | - L'administrateur web doit être connecté à son compte.<br> - Le fichier CSV doit être au format attendu (conformité des données). |
| **Garantie minimale**        | - L'utilisateur est ajouté à la base de données à partir du fichier CSV sans erreur.<br> - Les informations de l'utilisateur sont validées (par exemple, nom, prénom, email). |
| **Garantie maximale**        | - Un message de confirmation est affiché après l'ajout des utilisateurs.<br>  |
| **Scénario nominal**         | 1. Se connecter au compte admin.<br> 2. Ajouter un utilisateur via fichier CSV. |
| **Scénario alternatif**      | - Fichier CSV mal formaté.<br> - Données d'utilisateur invalides. |


---

### CUS 11

| **Nom**                      | Faire un calcul                             |
|------------------------------|----------------------------------------------|
| **Acteur Principal**         | Utilisateur                                  |
| **Portée**                   | Boîte noire                                  |
| **Niveau**                   | Fonctionnalité principale                    |
| **Description**              | L'utilisateur fait un calcul sur la plateforme. |
| **Précondition**             | - L'utilisateur doit être connecté et avoir accès aux modules de calcul.<br> - Le module choisi doit être valide et opérationnel. |
| **Garantie minimale**        | - Le calcul est effectué sans erreur et le résultat est retourné à l'utilisateur.<br> - L'utilisateur reçoit un message d'erreur si des variables sont manquantes ou incorrectes. |
| **Garantie maximale**        | - L'utilisateur peut choisir parmi plusieurs modules de calcul avec des interfaces adaptées (par exemple, des graphiques pour des résultats complexes).<br> - Les résultats de calcul sont stockés dans un historique que l'utilisateur peut consulter ultérieurement. |
| **Scénario nominal**         | 1. Se connecter.<br> 2. Sélectionner un module de calcul.<br> 3. Entrer les paramètres du calcul.<br> 4. Obtenir les résultats. |
| **Scénario alternatif**      | - Paramètres manquants.<br> - Erreur de calcul. |

---

### CUS 12

| **Nom**                      | Ajout d’un module de calcul                  |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Administrateur web                            |
| **Portée**                   | boite blanche                             |
| **Niveau**                   | Administrateur système                       |
| **Description**              | L'administrateur web ajoute un module de calcul à la plateforme. |
| **Précondition**             | - L'administrateur web doit être connecté.<br> - Le module de calcul à ajouter doit être préalablement développé ou prêt à être implémenté. |
| **Garantie minimale**        | - Le module de calcul est ajouté à la plateforme et fonctionne correctement. |
| **Garantie maximale**        | - Le module est testé pour diverses entrées afin de garantir sa fiabilité.<br> - Le module est documenté avec des instructions claires sur son utilisation. |
| **Scénario nominal**         | 1. Se connecter au compte admin.<br> 2. Ajouter le module de calcul via le panneau d'administration. |
| **Scénario alternatif**      | - Module de calcul mal développé.<br> - Erreur lors de l'intégration du module. |

---

### CUS 13

| **Nom**                      | Modifier un module de calcul                 |
|------------------------------|-----------------------------------------------|
| **Acteur Principal**         | Administrateur web                            |
| **Portée**                   | boite blanche                             |
| **Niveau**                   | Administrateur système                       |
| **Description**              | L'administrateur modifie un module de calcul existant. |
| **Précondition**             | - L'administrateur web ou développeur doit être connecté.<br> - Le module de calcul à modifier doit être accessible dans la base de données. |
| **Garantie minimale**        | - Le module de calcul est correctement modifié et fonctionnel après l'implémentation. |
| **Garantie maximale**        | - Les modifications sont testées avec différents types de données d'entrée.<br> - Une notification de succès est envoyée à l'administrateur après modification du module. |
| **Scénario nominal**         | 1. Se connecter au compte admin.<br> 2. Modifier un module de calcul.<br> 3. Tester le module modifié. |
| **Scénario alternatif**      | - Module de calcul non fonctionnel.<br> - Paramètres invalides dans la modification. |


