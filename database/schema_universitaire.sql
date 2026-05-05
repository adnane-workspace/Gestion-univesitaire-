-- ==========================================
-- SCHÉMA COMPLET DE BASE DE DONNÉES
-- APPLICATION DE GESTION UNIVERSITAIRE
-- ==========================================

-- Suppression des tables si elles existent (dans l'ordre inverse des dépendances)
DROP TABLE IF EXISTS `creneaux`;
DROP TABLE IF EXISTS `notes`;
DROP TABLE IF EXISTS `inscriptions`;
DROP TABLE IF EXISTS `students`;
DROP TABLE IF EXISTS `elements_modules`;
DROP TABLE IF EXISTS `modules`;
DROP TABLE IF EXISTS `salles`;
DROP TABLE IF EXISTS `filieres`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;

-- ==========================================
-- TABLE: users
-- Description: Authentification de base avec gestion des rôles
-- ==========================================
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'professeur', 'etudiant') NOT NULL DEFAULT 'etudiant',
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: password_reset_tokens
-- Description: Tokens de réinitialisation de mot de passe
-- ==========================================
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) PRIMARY KEY,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: sessions
-- Description: Sessions utilisateur
-- ==========================================
CREATE TABLE `sessions` (
    `id` VARCHAR(255) PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`),
    CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: filieres
-- Description: Liste des filières (ex: Génie Civil, Informatique)
-- ==========================================
CREATE TABLE `filieres` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `nom` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: modules
-- Description: Unités d'enseignement
-- Relations: filiere_id -> filieres(id)
-- ==========================================
CREATE TABLE `modules` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `nom` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `filiere_id` BIGINT UNSIGNED NOT NULL,
    `semestre` INT NOT NULL,
    `coefficient` INT NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `modules_filiere_id_index` (`filiere_id`),
    CONSTRAINT `modules_filiere_id_foreign` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: elements_modules
-- Description: Éléments constitutifs d'un module (avec coefficients)
-- Relations: module_id -> modules(id), professeur_id -> users(id)
-- ==========================================
CREATE TABLE `elements_modules` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `nom` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `module_id` BIGINT UNSIGNED NOT NULL,
    `coefficient` DECIMAL(3, 2) NOT NULL DEFAULT 1.00,
    `professeur_id` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `elements_modules_module_id_index` (`module_id`),
    INDEX `elements_modules_professeur_id_index` (`professeur_id`),
    CONSTRAINT `elements_modules_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
    CONSTRAINT `elements_modules_professeur_id_foreign` FOREIGN KEY (`professeur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: salles
-- Description: Salles de cours disponibles
-- ==========================================
CREATE TABLE `salles` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `nom` VARCHAR(255) NOT NULL,
    `batiment` VARCHAR(100) NULL,
    `capacite` INT NOT NULL DEFAULT 30,
    `type` ENUM('cours', 'tp', 'td', 'amphi') NOT NULL DEFAULT 'cours',
    `equipement` TEXT NULL,
    `disponible` BOOLEAN NOT NULL DEFAULT TRUE,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: students
-- Description: Informations spécifiques aux étudiants
-- Relations: user_id -> users(id), filiere_id -> filieres(id)
-- ==========================================
CREATE TABLE `students` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL UNIQUE,
    `numero_etudiant` VARCHAR(50) NOT NULL UNIQUE,
    `date_naissance` DATE NULL,
    `lieu_naissance` VARCHAR(255) NULL,
    `telephone` VARCHAR(20) NULL,
    `adresse` VARCHAR(255) NULL,
    `filiere_id` BIGINT UNSIGNED NULL,
    `annee_etude` INT NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `students_user_id_index` (`user_id`),
    INDEX `students_filiere_id_index` (`filiere_id`),
    CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `students_filiere_id_foreign` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: inscriptions
-- Description: Table pivot annuelle pour les inscriptions aux modules
-- Relations: student_id -> students(id), module_id -> modules(id), filiere_id -> filieres(id)
-- ==========================================
CREATE TABLE `inscriptions` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `student_id` BIGINT UNSIGNED NOT NULL,
    `module_id` BIGINT UNSIGNED NOT NULL,
    `filiere_id` BIGINT UNSIGNED NOT NULL,
    `annee_universitaire` VARCHAR(20) NOT NULL,
    `statut` ENUM('en_cours', 'valide', 'echec') NOT NULL DEFAULT 'en_cours',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `inscriptions_student_id_index` (`student_id`),
    INDEX `inscriptions_module_id_index` (`module_id`),
    INDEX `inscriptions_filiere_id_index` (`filiere_id`),
    CONSTRAINT `inscriptions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
    CONSTRAINT `inscriptions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
    CONSTRAINT `inscriptions_filiere_id_foreign` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE CASCADE,
    UNIQUE KEY `inscriptions_student_module_year_unique` (`student_id`, `module_id`, `annee_universitaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: notes
-- Description: Résultats des examens
-- Relations: student_id -> students(id), element_module_id -> elements_modules(id)
-- ==========================================
CREATE TABLE `notes` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `student_id` BIGINT UNSIGNED NOT NULL,
    `element_module_id` BIGINT UNSIGNED NOT NULL,
    `note` DECIMAL(5, 2) NOT NULL,
    `session` ENUM('normale', 'rattrapage') NOT NULL DEFAULT 'normale',
    `annee_universitaire` VARCHAR(20) NOT NULL,
    `observation` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `notes_student_id_index` (`student_id`),
    INDEX `notes_element_module_id_index` (`element_module_id`),
    CONSTRAINT `notes_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
    CONSTRAINT `notes_element_module_id_foreign` FOREIGN KEY (`element_module_id`) REFERENCES `elements_modules` (`id`) ON DELETE CASCADE,
    UNIQUE KEY `notes_student_element_session_year_unique` (`student_id`, `element_module_id`, `session`, `annee_universitaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: creneaux
-- Description: Créneaux horaires liant professeur, module et salle
-- Relations: professeur_id -> users(id), module_id -> modules(id), salle_id -> salles(id)
-- ==========================================
CREATE TABLE `creneaux` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `professeur_id` BIGINT UNSIGNED NOT NULL,
    `module_id` BIGINT UNSIGNED NOT NULL,
    `salle_id` BIGINT UNSIGNED NOT NULL,
    `jour` VARCHAR(20) NOT NULL,
    `heure_debut` TIME NOT NULL,
    `heure_fin` TIME NOT NULL,
    `type_seance` ENUM('cours', 'tp', 'td') NOT NULL DEFAULT 'cours',
    `groupe` VARCHAR(50) NULL,
    `annee_universitaire` VARCHAR(20) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `creneaux_professeur_id_index` (`professeur_id`),
    INDEX `creneaux_module_id_index` (`module_id`),
    INDEX `creneaux_salle_id_index` (`salle_id`),
    CONSTRAINT `creneaux_professeur_id_foreign` FOREIGN KEY (`professeur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `creneaux_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
    CONSTRAINT `creneaux_salle_id_foreign` FOREIGN KEY (`salle_id`) REFERENCES `salles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- DONNÉES D'EXEMPLE (OPTIONNEL)
-- ==========================================

-- Insertion de filières d'exemple
INSERT INTO `filieres` (`code`, `nom`, `description`) VALUES
('GI', 'Génie Informatique', 'Filière en génie informatique et développement logiciel'),
('GC', 'Génie Civil', 'Filière en génie civil et construction'),
('GE', 'Génie Électrique', 'Filière en génie électrique et électronique');

-- Insertion de salles d'exemple
INSERT INTO `salles` (`code`, `nom`, `batiment`, `capacite`, `type`, `disponible`) VALUES
('S101', 'Salle 101', 'A', 40, 'cours', TRUE),
('S201', 'Salle 201', 'B', 30, 'tp', TRUE),
('S301', 'Salle 301', 'C', 30, 'td', TRUE),
('AMP01', 'Amphithéâtre 1', 'D', 150, 'amphi', TRUE);

-- ==========================================
-- FIN DU SCHÉMA
-- ==========================================
