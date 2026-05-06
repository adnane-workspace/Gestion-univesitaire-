# Système de Gestion Académique UPF


## 🌟 Fonctionnalités Clés

- **Tableau de Bord Multi-Rôles** : Interfaces dédiées et optimisées pour chaque type d'utilisateur.
- **Gestion des Étudiants & Professeurs** : CRUD complet pour l'administration.
*   **Planification Académique** : Gestion des filières, modules, salles et emplois du temps dynamiques.
- **Gestion des Notes** : Saisie sécurisée par les professeurs et consultation en temps réel par les étudiants.
- **Calcul de Moyenne (GPA)** : Système automatisé de calcul de moyenne pondérée selon les coefficients.
- **Design Premium** : Interface basée sur Tailwind CSS avec une esthétique SaaS moderne (Geist/Inter fonts, Glassmorphism).

## 🛠️ Stack Technique

- **Backend** : Laravel 11
- **Frontend** : Blade, Tailwind CSS
- **Base de données** : MySQL
- **Tests** : PHPUnit avec couverture complète des fonctionnalités

## 🚀 Installation et Configuration

Suivez ces étapes pour installer le projet localement :

### 1. Prérequis
- PHP >= 8.2
- Composer
- Node.js & NPM

### 2. Clonage et Installation
```bash
# Cloner le dépôt
git clone https://github.com/adnane-workspace/Gestion-univesitaire-.git
cd Gestion-univesitaire-

# Installer les dépendances PHP
composer install

# Installer les dépendances JS
npm install
npm run dev
```

### 3. Configuration de l'environnement
```bash
# Créer le fichier .env
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Créez un fichier vide database/database.sqlite
touch database/database.sqlite
```

### 4. Migration et Seeding (Données de test)
```bash
# Lancer les migrations et remplir la base de données
php artisan migrate:fresh --seed
```

### 5. Lancer l'application
```bash
php artisan serve
```

## 🔐 Comptes de Test (Mot de passe par défaut : `password`)

| Rôle | Email |
| :--- | :--- |
| **Administrateur** | `admin@universite.com` | mdp: password
| **Professeur** | `marwan.kzadri@universite.com` |mdp:password
| **Étudiant** | `el.menouar.adnane@student.com` |mdp:password

## 🧪 Tests Automatisés

Le projet inclut une suite de tests complète (Feature & Unit).
Pour plus de détails, consultez le fichier [GUIDE_TESTS.md](GUIDE_TESTS.md).

```bash
php artisan test
```

## 📁 Structure du Projet (Points Clés)

- `app/Models/` : Logique métier (ex: `calculateGPA` dans `Student.php`).
- `app/Http/Controllers/` : Gestionnaires de requêtes pour chaque espace.
- `resources/views/layouts/` : Templates harmonisés (Admin, Dashboard).
- `tests/` : Suite de tests couvrant toute l'application.

