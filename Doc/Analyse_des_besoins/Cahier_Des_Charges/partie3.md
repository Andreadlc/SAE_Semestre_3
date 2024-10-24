## 2. Énoncé

L'application web à réaliser devra permettre aux utilisateurs de réaliser des calculs via différents modules, accessibles en fonction de leur statut (inscrit ou non). Le développement se fera en PHP et MySQL, mais l'utilisation d'autres serveurs SQL est envisageable.

### Types d'utilisateurs :

- **Visiteur (non inscrit)** :
    - Accès uniquement à la page d'accueil avec un texte explicatif et une vidéo promotionnelle.
    - N'a pas accès aux modules de calculs.

- **Utilisateur inscrit** :
    - Accès à un tableau de bord où il peut utiliser les différents modules de calculs.
    - Peut changer son mot de passe depuis son profil.
    - Peut sauvegarder les résultats des calculs dans un historique personnel.

- **Administrateur web** :
    - Se connecte avec un identifiant obligatoire (login : **adminweb**, mot de passe : **adminweb**).
    - Peut voir la liste des utilisateurs inscrits.
    - Peut ajouter des utilisateurs à partir d'un fichier CSV.
    - Peut supprimer des utilisateurs et les historiques associés. Un fichier de log est généré lors de chaque suppression.

- **Administrateur système** :
    - Accès aux journaux d'activités de la plateforme (login : **sysadmin**, mot de passe : **sysadmin**).
    - Ne participe pas à l'administration de la plateforme mais supervise son fonctionnement et son activité système.
