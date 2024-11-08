# V. Chapitre 5 – Autres Exigences

## (a) Processus de Développement

### i) Qui sont les participants au projet ?
Les participants au projet sont les développeurs (notre groupe) et le client.

### ii) Quelles valeurs devront être privilégiées ? 
(exemple : simplicité, disponibilité, rapidité, souplesse, etc.)
Dans le cadre de ce projet, différentes valeurs devront être privilégiées. Parmi elles, nous pouvons retrouver :
- **La flexibilité** : Au vu de la méthode de développement que nous allons utiliser, la flexibilité va nous permettre de concevoir la plateforme de manière à permettre des ajustements rapides en réponse au retour de l’utilisateur.
- **La fiabilité** : S’assurer que la plateforme fonctionne de manière fiable en minimisant les erreurs et en fournissant des fonctionnalités cohérentes.
- **La convivialité** : Chaque visiteur doit pouvoir naviguer sur le site en toute facilité, indépendamment de ses capacités visuelles. Nous prendrons en compte les besoins des daltoniens et d’autres utilisateurs ayant des exigences particulières en matière de perception de couleurs.
- **La sécurité** : Assurer la protection des données sensibles des utilisateurs et des informations de connexion.

### iii) Quels retours ou quelle visibilité sur le projet les utilisateurs et commanditaires souhaitent-ils ?
Concernant le projet, seul le client souhaite une visibilité sur l’avancement du projet. Nous lui avons fourni une maquette web afin qu’il puisse visualiser la page d’accueil et les différentes sections qui la composent. Le client souhaite que l’application web soit installée sur un serveur porté par un Raspberry Pi 4, qui sera disponible en connexion SSH depuis les postes des salles machines.

### iv) Que peut-on acheter ? Que doit-on construire ? Qui sont nos concurrents ?
Aucun achat n’a été prévu pour l’heure et nous n’avons pas à proprement dit de concurrent, mais nous pouvons prendre en compte les autres groupes de projet. L’environnement de développement que nous utilisons est financé par l’IUT et le serveur Raspberry Pi 4 est aussi fourni par l’IUT.

### v) Quelles sont les autres exigences du processus ? 
(exemple : tests, installation, etc.)
Le processus nécessite quelques exigences :
- Des tests pour s’assurer que tous les liens fonctionnent.
- Des tests pour vérifier que les requêtes effectuées sur la base de données concordent avec celles attendues.
- La configuration réseau du Raspberry Pi 4.
- Installation de Raspbian (système d’exploitation) sur le Raspberry Pi 4.
- Installation d’Apache.
- Installation de MariaDB.
- Installation de PHP.

### vi) À quelle dépendance le projet est-il soumis ?
Le projet est soumis à quelques dépendances :
- **GitHub** : La disponibilité d’un compte GitHub pour chaque développeur est nécessaire pour partager la documentation, les codes et d’autres informations liées au projet.
- **IDE** : La nécessité d’avoir un environnement de développement (comme Webstorm ou Visual Studio Code) afin de pouvoir développer dans les meilleures conditions les pages web nécessitant du HTML, du CSS, du PHP, du SQL et du JavaScript.
- **Serveur Raspberry Pi 4** : Ce serveur nous permettra de stocker notre site "Maths my Result" et sera disponible en connexion SSH.

## (b) Règles Métier
Afin d’avoir un gain de temps et de performance élevé, nous avons mis en place des règles métier que voici :
- **Communication interpersonnelle** : Utiliser un langage professionnel et respectueux dans toutes les communications.
- **Respect des délais** : Respecter les délais fixés pour les rendus des différents livrables.
- **Esprit d’équipe** : Encourager la collaboration et le partage des connaissances entre les membres de l’équipe.
- **Accessibilité** : S’assurer que toutes les communications, documents et plateforme respectent les principes d’accessibilité pour garantir l’inclusion de tous les utilisateurs.
- **Langue française** : Toutes documentations et communications écrites doivent être faites en langue française.

## (c) Performances
Voici quelques aspects de performance qui pourraient être considérés :
- La facilité à comprendre et à naviguer sur le site.
- La convivialité de l’interface utilisateur quel que soit le type d’utilisateur.
- Le formulaire d’inscription qui demande peu de renseignements.
- Un captcha a été mis en place pour vérifier que c’est bien un être humain qui tente de s’inscrire sur la plateforme.

## (d) Opérations, Sécurité, Documentation
Afin de permettre une navigation dans notre site web sans faille et tout en protégeant un maximum les données personnelles de nos utilisateurs, nous avons cherché à renforcer les mesures de sécurité au sein du site web pour permettre une utilisation sans fuite de données personnelles. Pour parvenir à nos fins, nous avons mis en place différentes solutions telles que :
- L’authentification des utilisateurs.
- Un algorithme de chiffrement des mots de passe.
- Un captcha.

## (e) Utilisation et Utilisabilité
Voici l’utilisation des différents éléments qui composent le système ainsi que leur utilisabilité :
- **Navigation** : La structure de la page d’accueil offre une navigation intuitive, permettant aux différents utilisateurs de comprendre rapidement comment accéder aux informations dont ils ont besoin. Cela garantit une expérience utilisateur fluide et réduit le temps.
- **Vidéo de présentation** : Une section dédiée à une vidéo explicative du site a été mise en place pour les futurs visiteurs afin de comprendre le fonctionnement du site web, facilitant ainsi leur intégration et adoption à la plateforme de module de calcul.
- **Connexion** : Une page de connexion permet à un utilisateur déjà inscrit dans la base de données de se connecter et d’avoir accès à certaines fonctionnalités.
- **Inscription** : Un formulaire d’inscription explicite et demandant peu de renseignements.
- **Accessibilité** : La plateforme est accessible à tous les utilisateurs, y compris ceux ayant des besoins spécifiques tels que les utilisateurs avec des déficiences visuelles. Cela démontre un engagement envers l’inclusion et l’accessibilité pour tous les utilisateurs.

## (f) Maintenance et Portabilité
La portabilité de notre plateforme web pour ce projet possède une capacité à s’adapter à divers environnements informatiques. Cette possibilité se manifeste par sa flexibilité de déploiement sur différents serveurs, notamment sur le Raspberry Pi 4. La plateforme assure une compatibilité sur différents systèmes d’exploitation et navigateurs web, permettant ainsi aux utilisateurs d’accéder à la plateforme web dans la grande majorité des cas.

## (g) Questions Non Résolues ou Reportées
- Méthode de récupération de mot de passe utilisateur non incluse.
