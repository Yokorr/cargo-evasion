# 🏁 Sprint 1 : Fondations, Sécurité & Data (18 Heures)

**Objectif :** Atteindre 20% de la valeur métier en livrant un squelette technique fonctionnel, une base de données opérationnelle et un système de rôles sécurisé.

---

## 📅 SEMAINE 1 : Architecture et Moteur de Données (9h)

  - Initialisation
- [ ] `composer create-project laravel/laravel cargo-evasion`
- [ ] Initialisation du dépôt Git (`git init`) et premier commit.
- [ ] Configuration du fichier `.env` (Base de données local).

 - Authentification
- [ ] Installation de Laravel Breeze : `composer require laravel/breeze --dev`.
- [ ] `php artisan breeze:install blade`.
- [ ] Test du cycle Inscription / Connexion.

 - Migrations Simples
- [ ] Création et édition de la migration `bikes` (champs : serial_number, model, status).
- [ ] Création et édition de la migration `daily_codes` (champs : date_day, access_code).
- [ ] `php artisan migrate`.

 - Migrations Complexes & Clés Étrangères
- [ ] Création de la migration `bookings` (clés étrangères vers users et bikes).
- [ ] Ajout de la colonne `role` (default: 'user') dans la table `users`.
- [ ] Exécution et vérification de la structure dans la base de données.

 - Modèles & Seeders (Données de test)
- [ ] Définition des relations Eloquent dans les modèles (`User`, `Bike`, `Booking`).
- [ ] Création d'un `BikeSeeder` pour générer 10 vélos de test.
- [ ] `php artisan db:seed` : Vérifier que la base n'est plus vide.

 - Sécurité (Middleware)
- [ ] Création du Middleware `IsAdmin` : `php artisan make:middleware IsAdmin`.
- [ ] Logique de vérification du rôle (`Auth::user()->role === 'admin'`).
- [ ] Enregistrement du middleware dans `bootstrap/app.php`.

 - Validation technique
- [ ] Test manuel : Un utilisateur `user` ne doit pas accéder à une route protégée.
- [ ] Nettoyage des fichiers inutiles et commit de fin de semaine.

---

## 📅 SEMAINE 2 : Backend Admin & Intégration Front (9h)

 - Architecture des Routes
- [ ] Définition du groupe de routes `prefix('admin')` avec le middleware `IsAdmin`.
- [ ] Création de `AdminController`.

- Interface Admin : Liste des vélos
- [ ] Création de la vue `admin.bikes.index`.
- [ ] Affichage de la flotte sous forme de tableau (Tailwind CSS).

 - Logique Maintenance (F3)
- [ ] Création de la méthode `updateStatus` dans le contrôleur.
- [ ] Ajout du bouton "Passer en maintenance" sur l'interface admin.

- Gestion des Codes (F2)
- [ ] Création de la vue `admin.codes.index`.
- [ ] Formulaire de saisie du code journalier (Date et Code).
- [ ] Logique de sauvegarde `DailyCode::updateOrCreate()`.

 - Intégration Front : Landing Page (Figma 1)
- [ ] Création de la vue `welcome.blade.php`.
- [ ] Intégration du Header et de la section "Hero" avec Tailwind.
- [ ] Respect des arrondis (24px) et des ombres définis dans Figma.

 - Données Dynamiques
- [ ] Passage de la variable `$bikesCount` du contrôleur à la Landing Page.
- [ ] Affichage dynamique : "X vélos disponibles à la location".

 - Revue de Sprint & Clôture
- [ ] Vérification de la conformité avec le cahier des charges.
- [ ] Préparation du backlog pour le Sprint 2 (Paiement Monetico).
- [ ] `git push origin main`.
