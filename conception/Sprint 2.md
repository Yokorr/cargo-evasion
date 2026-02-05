# Sprint 2 : Réservation & Paiement (Février 2026)

## 🎯 Objectif global
Mettre en place un **tunnel de réservation complet** (inspiration **SIXT**) avec :
- gestion de **tarifs flexibles**
- intégration du **paiement Monetico**

---

## 📅 Semaine 1 : Moteur de Disponibilité & Gestion des Tarifs (9h)

### 🟢 Jeudi — Architecture des prix (2h)
- Migration de la table `prices`
- Création du modèle `Price`
- Mise en place de l’interface **Admin** pour configurer les tarifs par vélo

### 🟢 Vendredi — Le "cerveau" de disponibilité (2h)
- Développement de la logique **PHP**
- Vérification de la disponibilité d’un vélo sur un créneau date/heure donné

### 🟢 Samedi — Front-end inspiration SIXT (2h)
- Création de la page **« Nos Vélos »**
- Barre de sélection **Date / Heure**
- Filtrage dynamique des vélos disponibles

### 🟢 Dimanche — Liaison & calcul des prix (1h)
- Calcul dynamique du **prix final**
- Prise en compte du vélo sélectionné et de la durée de réservation

### ✨ Extra — Finition & robustesse (2h)
- Polissage de l’interface utilisateur
- Tests de robustesse et scénarios limites
