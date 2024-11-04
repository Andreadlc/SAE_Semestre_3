# III. Les cas d’utilisation

## (a) Acteurs principaux et leurs objectifs généraux
- **Administrateur système** : Suivre les activités de la plateforme via des journaux d’activité.
- **Administrateur web** : Gérer les comptes utilisateurs et l’historique des utilisateurs inscrits.
- **Utilisateur inscrit** : Utiliser les modules de calcul et accéder à son historique de calculs.
- **Visiteur** : Consulter les informations générales de la plateforme.

## (b) Cas d’utilisation métier (concepts opérationnels)
- **Gestion de l’accès utilisateur** : Permet aux visiteurs de s'inscrire pour devenir utilisateurs, avec un formulaire de sécurité incluant un captcha.
- **Gestion des comptes** : L’administrateur web peut créer, supprimer, et modifier des comptes utilisateurs.
- **Suivi de l’activité** : L’administrateur système surveille les logs d’activité.

## (c) Cas d’utilisation système
- **Inscription d’un visiteur** : Un visiteur s'inscrit pour devenir utilisateur, remplissant un formulaire avec un captcha.
- **Connexion d’un utilisateur inscrit** : Un utilisateur connecté accède aux modules de calcul.
- **Gestion des logs par l’administrateur système** : Accès aux journaux de logs.
- **Gestion des utilisateurs par l’administrateur web** : Création et suppression de comptes.
