## 2. Énoncé
*Description détaillée du problème à résoudre, le contexte, les objectifs du projet. Si besoin, on fait une présentation 
de l’existant. Définition des objectifs que doit atteindre la solution.*

Le projet consiste à développer une **plateforme web de modules de calculs** qui offre aux utilisateurs des outils interactifs pour effectuer divers calculs. Cette plateforme est destinée à quatre types d’utilisateurs : visiteurs, utilisateurs inscrits, administrateur web, et administrateur système. Chaque catégorie d’utilisateurs aura des droits et fonctionnalités spécifiques, permettant une gestion efficace et sécurisée de leurs interactions avec l’application.

L’objectif principal est de fournir une solution centralisée, intuitive et sécurisée, accessible via une interface web hébergée sur un **Raspberry Pi 4**. Cette plateforme devra répondre à des besoins pédagogiques et techniques, tout en assurant une traçabilité complète des actions effectuées par les utilisateurs.

---

### Types d'utilisateurs :
| **Type d’utilisateur**   | **Droits et responsabilités**                                                                                                           |
|---------------------------|-----------------------------------------------------------------------------------------------------------------------------------------|
| **Visiteur**              |                                                       |
|                            |  - Accès à la page d’accueil avec un texte explicatif et une vidéo de démonstration.                                                    |
|                           | - Visualisation d’informations générales (sans accès aux modules de calcul).                                                          |
|                           | - Possibilité de s’inscrire via un formulaire sécurisé (incluant un captcha).                                                         |
|                           | - Accès à un lien « mot de passe oublié » menant à une page en construction.                                                          |
| **Utilisateur inscrit**   |                                                             |
|                            |- Accès à un tableau de bord regroupant les différents modules de calcul. |
|                           | - Consultation et gestion d’un historique des calculs enregistrés.                                                                    |
|                           | - Gestion du profil utilisateur (modification de mot de passe, suppression de compte).                                                |
|                           | - Connexion et déconnexion via une interface sécurisée.                                                                               |
| **Administrateur web**    |                                                      |
|                            |- Utilisation d’un compte unique avec des identifiants prédéfinis (`adminweb`).  |
|                           | - Supervision des utilisateurs : création de comptes via CSV, suppression de comptes et des historiques associés.                     |
|                           | - Gestion des fichiers de logs pour les connexions et activités sur la plateforme.                                                    |
|                           | - Détermination des statuts et paramètres des modules de calcul (actif, désactivé, etc.).                                             |
| **Administrateur système**|                                                                       |
|                            |- Accès aux journaux d’activités système via la plateforme web. |
|                           | - Analyse des logs pour détecter des anomalies ou des tentatives de connexions non autorisées.                                        |
|                           | - Aucune intervention directe sur les fonctionnalités web.                                                                            |


---
Le client demande la mise en place d’un **système de journalisation** pour assurer une gestion sécurisée et un suivi précis des actions réalisées sur la plateforme. Ce mécanisme permettra de conserver un historique des activités pour des raisons de conformité, de sécurité et d’optimisation des performances. 

Dans le cadre de ce projet, la journalisation inclura l’enregistrement des événements liés à l’utilisation des modules de calcul et des tentatives de connexion infructueuses. Ces informations joueront un rôle crucial dans le suivi des interactions avec la plateforme et dans la détection d’éventuelles anomalies. Voici les cas de figure et les données enregistrées correspondantes :

| Raisons                             | Données enregistrées                                                                                          |
|-------------------------------------|---------------------------------------------------------------------------------------------------------------|
| Utilisation d’un module de calcul   | – la date<br/>– l’adresse IP<br/>– l’identifiant de l’utilisateur ayant initié l’action<br/>– <u>le module utilisé</u> |
| Tentative de connexion infructueuse | – la date<br/>– l’adresse IP<br/>– le login tenté<br/>– <u>le mot de passe tenté</u>                           |


---
La plateforme devra être installée sur un serveur porté par un raspberry pi, qui est un petit ordinateur 
monocarte souvent utilisé pour des expériences. Dans le contexte de notre projet, le Raspberry Pi est utilisé comme 
plateforme de déploiement pour héberger notre application web MathMyResult. Cela implique l'installation d'un système 
d'exploitation (raspbian dans notre cas), ainsi que des services nécessaires tels qu'un serveur web (comme Apache) et
un serveur de base de données (mariaDB dans notre cas). Une fois configuré, le Raspberry Pi agira comme un serveur 
accessible depuis les postes des salles informatiques via une connexion SSH, et éventuellement depuis l'extérieur via un
tunnel SSH, pour fournir l'accès à l'application de ticketing. Voici les différentes installations effectuées sur notre
raspberry pi :


| Installation               | nom       |
|----------------------------|-----------|
| Système d'exploitation     | raspbian  |
| Serveur web                | apache    |
| serveur de base de données | mariaDB   |



Pour la réalisation de ce projet, nous avons suivi une méthodologie progressive et structurée, en commençant par l’élaboration de la **charte graphique**. Cette étape nous a permis de définir les couleurs, la typographie, ainsi que le logo de la plateforme, assurant ainsi une identité visuelle cohérente tout au long du développement. Une fois cette étape terminée, nous avons créé une **maquette de la page d’accueil**, qui a permis de définir l’architecture de la page ainsi que les éléments visuels à y intégrer.

Dans une approche itérative, nous avons ensuite débuté le **développement statique** de la plateforme. La première page réalisée a été la page d'accueil, en utilisant les technologies **HTML** et **CSS**. Nous avons veillé à respecter les spécifications de la maquette et de la charte graphique afin de garantir une expérience visuelle uniforme. Une fois la page d’accueil validée par l’équipe, nous avons progressivement développé les autres pages du site, tout en restant sur un site statique à ce stade, sans interaction avec une base de données ou des scripts serveur. Durant cette phase, nous avons également configuré le **Raspberry Pi**, qui hébergera l'application. La préparation de la carte SD et l’installation de l’environnement nécessaire ont été réalisées pour que le serveur soit opérationnel.

Une fois la structure du site finalisée et le Raspberry Pi prêt, nous avons entamé la **phase de développement dynamique** en utilisant **PHP**. Cela nous a permis d’ajouter des fonctionnalités interactives essentielles pour notre projet, telles que la gestion des utilisateurs (inscription, connexion, profil) et la gestion des modules de calcul. Chaque module de calcul a été développé et intégré, permettant aux utilisateurs de soumettre des calculs complexes (par exemple, calculs vectoriels, matrices, etc.), de voir les résultats en temps réel et de sauvegarder l’historique de leurs calculs.

Nous avons également intégré la **gestion des logs** pour suivre les actions des utilisateurs, telles que la soumission de calculs, afin de garantir la sécurité et d’assurer une trace des activités pour des raisons de conformité et de suivi des performances.

Enfin, en suivant cette approche itérative et incrémentale, nous avons pu tester et valider les fonctionnalités du site à chaque étape du développement, garantissant ainsi la cohérence de l'interface utilisateur et la bonne gestion des modules de calcul. Grâce à cette méthodologie, nous avons pu créer une plateforme robuste, facile à utiliser, tout en respectant les exigences techniques et fonctionnelles du client.


