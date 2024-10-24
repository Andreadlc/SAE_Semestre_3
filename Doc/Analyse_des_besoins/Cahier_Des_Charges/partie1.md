# SAE_Semestre_3


| **Objets**                  | **Acteur** | **Actions**                                                        |
|-----------------------------|----------|---------------------------------------------------------------------|
| application web             | administrateur du système | effectuer des calculs                                               |
| plateforme                  | administrateur web | visualiser les informations                                         |
| serveur                     | utilisateur inscrit | intérêt de s'inscrire                                               |
| postes                      | visiteur | inscrire                                                            |
| plateforme web              |  | vérification d’un formulaire d'inscription                          |
| page accueil                |  | résoudre une addition ou soustraction                               |
| tableau de bord             |  | serveur consultable par l’administrateur web                        |
| vidéo                       |  | récupération de mot de passe                                        |
| modules                     |  | cliquer sur le lien mot de passe oublié                             |
| fichier logs                |  | accéder à son profil pour changer son mot de passe                  |
| page web                    |  | on peut stocker certains résultats de calcul                        |
| modules de calculs          |  | créer un fichier log                                                |
| historique                  |  | L’administrateur web se connecte                                    |
| formulaire d’inscription     | | L’administrateur web peut voir la liste des utilisateurs inscrits    |
| formulaire d’inscription     |  | L’administrateur web peut créer des comptes utilisateurs à partir d’un fichier CSV |
| formulaire d’inscription     |          | L’administrateur web peut supprimer des comptes utilisateurs et l’historique liés à ces comptes |






# Exigences du projet

## Exigences techniques :

### Technologies :
- Utiliser PHP pour le développement de l'application web.
- Stocker les données dans une base de données MySQL (ou un autre serveur SQL compatible).
- Hébergement sur un Raspberry Pi 4 avec un serveur web (ex. Apache).

### Sécurité :
- Protéger les accès au système via des connexions SSH sécurisées.
- Mettre en place un système d'authentification pour les administrateurs (système et web) et les utilisateurs.
- Le login par défaut pour les administrateurs doit être **pisae** avec un mot de passe spécifique **!pisae!**.

### Infrastructure :
- Installer et configurer le serveur web et le serveur SGBD sur le Raspberry Pi.
- Préparer une carte SD avec l'OS, les serveurs et les services requis pour le projet.
- Les identifiants d'administration système sont obligatoires : **sysadmin** pour l'administrateur système et **adminweb** pour l'administrateur web.

### Logs et supervision :
- Générer des journaux d'activités (logs) pour l'administrateur système afin de surveiller les actions sur la plateforme.
- Un fichier de logs doit être maintenu pour enregistrer les connexions et actions des utilisateurs.

### Réseau :
- Configurer les paramètres réseau du Raspberry Pi pour qu'il soit accessible via les postes des salles machines (et éventuellement en tunnel SSH externe).

## Exigences fonctionnelles :

### Types d'utilisateurs :

- **Visiteur (non inscrit)** :
    - Accéder uniquement à la page d’accueil et à une vidéo explicative.
    - Ne peut pas utiliser les modules de calcul.

- **Utilisateur inscrit** :
    - Accès aux modules de calcul proposés par la plateforme.
    - Accéder à son profil utilisateur pour changer son mot de passe.
    - Stocker certains résultats de calculs dans un historique personnel.

- **Administrateur web** :
    - Peut gérer les utilisateurs inscrits (créer des comptes via CSV, supprimer des comptes et leur historique).
    - Consulter les logs des actions liées à la gestion des utilisateurs.

- **Administrateur système** :
    - Accès aux journaux d'activités du système via la plateforme web pour suivre les événements techniques.

### Inscription et connexion :
- Un visiteur peut s’inscrire via un formulaire d'inscription avec un CAPTCHA simple (ex : addition ou multiplication) pour devenir un utilisateur.
- Il n'y a pas de confirmation d'inscription via e-mail ou SMS.
- Un fichier de logs devra enregistrer les inscriptions.

### Modules de calcul :
- L'utilisateur inscrit peut accéder aux différents modules de calcul fournis par la plateforme.
- Il peut sauvegarder les résultats des calculs dans son historique personnel pour consultation ultérieure.

### Gestion des mots de passe :
- Possibilité de changer de mot de passe via le profil utilisateur.
- Afficher une page "mot de passe oublié" en construction sans fournir de méthode de récupération.

### Vidéo explicative :
- Une vidéo sur la page d'accueil qui explique le fonctionnement de la plateforme et encourage les visiteurs à s’inscrire.

---

# Questions à poser pour lever des ambiguïtés

## Catégorie : Modules de calcul

- **Quels types de modules de calcul doivent être inclus ?** (addition, soustraction, etc.)
- **Y a-t-il des calculs spécifiques au secteur d'activité du client à implémenter ?**
- **Combien de pages ou étapes par module de calcul sont prévues ?** (ex. : saisie, résultat, récapitulatif)
- **Certains modules doivent-ils être réservés à certains types d’utilisateurs ?** (ex : inscrits, administrateurs)

## Catégorie : Inscription et sécurité

- **Quelle est la fréquence de réinitialisation souhaitée pour les mots de passe ?**
- **Souhaitez-vous un captcha standard (Google reCAPTCHA) ou un captcha personnalisé ?**
- **Quelles mesures de sécurité supplémentaires sont souhaitées ?** (ex. : chiffrement, authentification multi-facteurs pour les administrateurs)
- **Existe-t-il une politique spécifique sur la confidentialité et la conservation des données utilisateurs ?**

## Catégorie : Données et fichiers logs

- **Combien de temps les fichiers logs doivent-ils être conservés ?**
- **La plateforme doit-elle inclure un système de sauvegarde automatique pour les données ?**

## Catégorie : Interface et design

- **Le client souhaite-t-il utiliser un template existant ou un design spécifique pour l'interface ?**
- **Quelles personnalisations sont nécessaires entre les différents utilisateurs (visiteur, utilisateur inscrit, administrateur) ?**

## Catégorie : Développement et maintenance

- **PHP/MySQL est-il suffisant ou souhaitez-vous d'autres technologies ?**
- **Envisagez-vous des mises à jour ou ajouts de fonctionnalités après le déploiement initial ?**
