# I. Objectif et portée

## (a) Portée et objectifs généraux
L’objectif principal de ce projet est de créer une application web permettant aux utilisateurs d’accéder à divers modules de calculs via une plateforme web accessible depuis un Raspberry Pi 4, configuré en serveur. Ce projet a une portée éducative, mobilisant des compétences techniques des semestres 3 et 4 en développement web, administration de serveurs, sécurité, et gestion de base de données. L’application devra être sécurisée et offrir des interfaces simples d’utilisation pour différents profils d’utilisateurs.

## (b) Intervenants
- **Administrateur système** : Surveille les journaux d’activité de la plateforme web. Il n’interagit pas directement avec les modules de calcul.
- **Administrateur web** : Gère les utilisateurs inscrits, crée des comptes en masse, et supprime des comptes avec un suivi de logs.
- **Utilisateur inscrit** : Accède aux modules de calcul, consulte l’historique de calculs et gère son profil.
- **Visiteur** : Peut accéder aux informations générales de la plateforme, mais sans utiliser les modules de calcul.

## (c) Limites du système
### Ce qui entre dans la portée :
- Accès à un tableau de bord des modules de calcul pour les utilisateurs inscrits.
- Sécurité des connexions utilisateurs.
- Gestion de l’historique des calculs pour les utilisateurs inscrits.
- Interface d’administration pour la gestion des comptes.
- Interface de logs pour l’administrateur système.

### Ce qui est hors de la portée :
- Confirmation d’inscription par email ou SMS.
- Récupération de mot de passe par email ou SMS (une page placeholder sera affichée pour les mots de passe oubliés).
- Toute modification des identifiants de l’administrateur web ou système.
