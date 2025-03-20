CREATE TABLE utilisateur (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             nom_utilisateur VARCHAR(255) NOT NULL UNIQUE,
                             mot_de_passe VARCHAR(255) NOT NULL,
                             date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             role INT NOT NULL
);

CREATE TABLE resultat_probabilite (
                                      id INT AUTO_INCREMENT PRIMARY KEY,             -- Identifiant unique du calcul
                                      utilisateur_id INT NOT NULL,                   -- Identifiant de l'utilisateur qui a effectué le calcul
                                      esperance_mu FLOAT NOT NULL,                   -- Espérance μ utilisée dans le calcul
                                      forme_lambda FLOAT NOT NULL,                   -- Paramètre λ utilisé dans le calcul
                                      valeur_t FLOAT NOT NULL,                       -- Valeur t pour P(X ≤ t)
                                      nombre_valeurs_n INT NOT NULL,                 -- Nombre de valeurs prises sur l'intervalle n ≥ 1
                                      methode_calcul VARCHAR(255) NOT NULL,          -- Méthode numérique utilisée (e.g., Méthode 1, Méthode 2, etc.)
                                      valeur_probabilite FLOAT NOT NULL,             -- Résultat de la probabilité calculée
                                      moyenne_x FLOAT NOT NULL,                      -- Valeur moyenne \overline{X} (calculée si nécessaire)
                                      ecart_type_sigma FLOAT NOT NULL,               -- Écart type σ calculé
                                      date_calcul TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date et heure du calcul
                                      FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) -- Clé étrangère liée à la table utilisateur
);
CREATE TABLE resultat_polynome (
                                   id INT AUTO_INCREMENT PRIMARY KEY,                -- Identifiant unique du calcul
                                   utilisateur_id INT NOT NULL,                       -- Identifiant de l'utilisateur qui a effectué le calcul
                                   coefficient_a FLOAT NOT NULL,                      -- Coefficient a de l'équation quadratique
                                   coefficient_b FLOAT NOT NULL,                      -- Coefficient b de l'équation quadratique
                                   coefficient_c FLOAT NOT NULL,                      -- Coefficient c de l'équation quadratique
                                   discriminant FLOAT NOT NULL,                       -- Valeur du discriminant
                                   racine_1 VARCHAR(255) NOT NULL,                     -- Première racine sous forme de chaîne (par exemple "1-2i" ou "1+2i")
                                   racine_2 VARCHAR(255) NOT NULL,                     -- Deuxième racine sous forme de chaîne (par exemple "1+2i" ou "1-2i")
                                   date_calcul TIMESTAMP DEFAULT CURRENT_TIMESTAMP,   -- Date et heure du calcul
                                   FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)  -- Clé étrangère liée à la table utilisateur
);

CREATE TABLE historique_crypto (
                                   id INT AUTO_INCREMENT PRIMARY KEY,
                                   utilisateur_id INT NOT NULL,
                                   cle VARCHAR(255) NOT NULL,
                                   text TEXT NOT NULL,
                                   operation ENUM('chiffrement', 'dechiffrement') NOT NULL,
                                   date_calcul TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                   texte_original TEXT NOT NULL,
                                   FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);

