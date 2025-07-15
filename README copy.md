# GestEdu - Système de Gestion Scolaire

## Présentation

GestEdu est une application complète de gestion scolaire développée avec Laravel 11, utilisant Blade pour les templates, Bootstrap 5 pour l'interface utilisateur, et MySQL pour la base de données.

## Fonctionnalités principales

- **Gestion des étudiants** : inscription, suivi, gestion des notes
- **Gestion des enseignants** : informations personnelles, matières enseignées
- **Gestion des parents/tuteurs** : coordonnées, lien avec les étudiants
- **Suivi des présences** : enregistrement et rapports
- **Gestion des examens** : planification, résultats
- **Gestion des paiements** : frais scolaires, reçus, rappels
- **Emplois du temps** : planification des cours et activités

## Structure technique

### Base de données

La base de données comprend 24 tables interconnectées pour gérer tous les aspects de l'établissement scolaire :
- Tables principales : students, teachers, supervisors, accountants
- Tables de relation : supervisor_student, study_level_subject
- Tables de fonctionnalités : examinations, attendance, payments, schedules

### Interface utilisateur

- **Design responsive** avec Bootstrap 5
- **Interface intuitive** avec tableaux de bord spécifiques par rôle
- **Composants réutilisables** pour une expérience utilisateur cohérente
- **Icônes** avec Font Awesome pour une meilleure lisibilité

## Fichiers clés à importer

### Migrations de base de données
- 24 fichiers de migration (format `database/migrations/YYYY_MM_DD_XXXXXX_*.php`)

### Templates et vues
- Layouts : `resources/views/layouts/app.blade.php` et `auth.blade.php`
- Authentification : `resources/views/auth/login.blade.php`
- Tableaux de bord : `resources/views/dashboard/admin.blade.php`
- Gestion des étudiants : `resources/views/students/*.blade.php`
- Autres modules : vues pour enseignants, parents, paiements, etc.

## Utilisation dans votre environnement WampServer

### Installation

Consultez le fichier `INSTALLATION.md` pour les instructions détaillées sur la mise en place de ce projet dans votre environnement local WampServer.

### Personnalisation

1. **Adaptation à votre établissement** :
   - Modifiez les libellés, logos et couleurs selon votre identité visuelle
   - Adaptez les champs des formulaires selon vos besoins spécifiques

2. **Extension des fonctionnalités** :
   - Ajoutez des modules supplémentaires au besoin
   - Personnalisez les rapports et les tableaux de bord

## Mise en production

Pour déployer cette application en production :

1. Configurez un serveur web avec PHP 8.1+ et MySQL 5.7+
2. Suivez les bonnes pratiques de sécurité Laravel (variables d'environnement, HTTPS)
3. Optimisez la configuration pour les performances (cache, compression)

## Support technique

Pour toute question ou assistance concernant l'installation ou l'utilisation de ce système, n'hésitez pas à nous contacter.

---

Développé avec Laravel 11, Bootstrap 5, et MySQL.