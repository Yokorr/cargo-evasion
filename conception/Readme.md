Dossier de Conception : Projet Cargo Évasion (Sports Carbone)
1. Présentation du Projet
Porteur de projet : Sports Carbone (Sud Essonne).

Vision : Offre de location autonome de vélos cargos électriques (triporteurs) disponible 24h/24 et 7j/7.

Innovation : Système de retrait/dépose autonome via QR Code et boîte à clés, sans présence physique requise.

Objectif : Faciliter la mobilité douce pour les familles touristiques et locales.

2. Analyse Fonctionnelle (UML)
Le système s'articule autour de deux acteurs principaux : le Client et l'Administrateur (qui hérite des droits du client).

2.1 Cas d'Utilisation (Use Case)
Client : Consulter les dispos, s'authentifier, réserver, payer (Monetico), recevoir le code d'accès.

Admin : (Hérite du Client) + Gérer la flotte, gérer les tarifs, configurer les codes journaliers, attribuer des rôles.

2.2 Fonctionnalités Métier (Détails)
F1 - Réservation & Paiement : Tunnel d'achat sécurisé avec gestion de la caution via Monetico.

F2 - Automatisation de l'Accès : Système évolutif (Code journalier manuel vers code unique IoT) transmis par SMS/Email.

F3 - Maintenance & Disponibilité : Expertise technique (cadre carbone) permettant de bloquer/débloquer des vélos en temps réel.

F4 - CRM & Fidélisation : Gestion des comptes, vérification d'identité et historique de location.

3. Architecture Technique
Stack : Laravel (PHP), Tailwind CSS, MySQL.

Sécurité : Middleware IsAdmin pour protéger les accès sensibles.

Authentification : Laravel Breeze (système robuste de Login/Register).

3.1 Plan des Routes (URLs)
Public : /, /catalogue, /login, /register.

Client (Connecté) : /reserver, /mon-compte, /paiement.

Admin (Protégé) : /admin/dashboard, /admin/velos, /admin/codes, /admin/utilisateurs.

4. Modélisation des Données (Base de Données)
4.1 Modèle Physique de Données (MPD)
Users : id, name, email, password, role (enum: user, admin), identity_verified.

Bikes : id, serial_number, model, status (avail, maint, rented).

DailyCodes : date_day (PK), access_code.

Bookings : id, user_id (FK), bike_id (FK), start_date, end_date, total_price, status, monetico_token.

5. Interface Utilisateur (UI/UX)
Design System : Mobile-First, arrondis (24px), ombres portées douces, typographie Inter.

Écran 1 (Landing) : Visuel fort, réassurance (Sports Carbone), bouton d'action immédiat.

Écran 2 (Sélection) : Calendrier épuré et cartes de créneaux (Matin/Après-midi/Journée) avec affichage des prix.

6. Plan de Développement (Sprint 1)
Durée : 18 heures sur 2 semaines.

Objectif (20% de valeur) : Squelette technique, Base de données, Authentification et Rôles.