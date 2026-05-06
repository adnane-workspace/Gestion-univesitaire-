# Guide des Tests Automatisés - EduPortal UPF

Ce document explique le fonctionnement de la suite complète de tests automatisés mise en place pour l'application.

## 🚀 Comment lancer les tests ?

Pour exécuter l'ensemble de la suite de tests (environ 20+ tests couvrant toute l'application) :

```bash
php artisan test
```

### Options utiles :
- `php artisan test --filter AdminManagementTest` : Teste spécifiquement la gestion administrative.
- `php artisan test --filter ProfessorAccessTest` : Teste spécifiquement l'espace professeur.
- `php artisan test --filter StudentAccessTest` : Teste spécifiquement l'espace étudiant.

---

## 🏗️ Couverture Applicative

### 1. Administration (`tests/Feature/AdminManagementTest.php`)
Vérifie que l'administrateur peut gérer toutes les entités du système :
*   **Filières** : Création, modification et suppression.
*   **Modules** : Association avec les filières.
*   **Salles** : Gestion des capacités et types de salles.
*   **Professeurs** : Création de comptes et profils liés.
*   **Étudiants** : Inscription et attribution de filières.

### 2. Espace Professeur (`tests/Feature/ProfessorAccessTest.php`)
*   **Modules** : Vérifie que le prof voit bien ses propres modules assignés.
*   **Emploi du Temps** : Vérifie l'affichage correct des créneaux de cours.
*   **Saisie des Notes** : Vérifie l'enregistrement en base de données.

### 3. Espace Étudiant (`tests/Feature/StudentAccessTest.php`)
*   **Notes** : Vérifie que l'étudiant accède à ses résultats en temps réel.
*   **Planning** : Vérifie que l'emploi du temps correspond à sa filière.
*   **Dashboard** : Vérifie l'affichage personnalisé du profil.

### 4. Sécurité & Auth (`tests/Feature/AuthenticationTest.php`)
*   **RBAC (Role Based Access Control)** : Empêche un étudiant d'accéder aux routes admin (403 Forbidden).
*   **Redirection intelligente** : Chaque rôle est dirigé vers sa page d'accueil spécifique après login.

### 5. Logique Métier (`tests/Unit/StudentGPATest.php`)
*   **Calcul de GPA** : Test mathématique pur sur la pondération des notes avec coefficients.

---

## 🛠️ Outils utilisés
- **RefreshDatabase** : Réinitialise la base SQLite en mémoire avant chaque test.
- **Factories** : Génération automatique de données réalistes pour les tests.
- **Pest/PHPUnit** : Moteur de test standard de Laravel.

---
*Généré par EduPortal UPF - Excellence et Qualité logicielle.*
