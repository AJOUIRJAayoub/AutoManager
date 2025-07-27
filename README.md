# AutoManager

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=flat&logo=bootstrap&logoColor=white)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=flat&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=flat&logo=css3&logoColor=white)

**AutoManager** est une application de gestion de pièces automobiles, conçue pour gérer l'ajout, la modification, la suppression et l'affichage de pièces via une interface web moderne.

---

## Fonctionnalités

- CRUD complet sur les pièces auto
- Système de catégories personnalisables
- Recherche par nom
- Filtre par catégorie
- Tri par prix ou stock
- Pagination
- Authentification admin sécurisée
- Interface responsive avec Bootstrap 5
- Alerte stock faible (≤ 5 pièces)

---

## Technologies utilisées

- PHP 8+
- MySQL
- HTML/CSS/JS
- Bootstrap 5
- Architecture MVC simple
- Sessions PHP pour l'authentification
- PDO pour la sécurité des requêtes

---

## Installation

### 1. Clone le dépôt
```bash
git clone https://github.com/AJOUIRJAayoub/AutoManager.git
cd AutoManager
```

### 2. Configure ta base de données

Crée une base nommée `automanager` et exécute cette requête :

```sql
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE pieces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2),
    stock INT,
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);
```

### 3. Configure la connexion MySQL

Dans `app/core/Database.php`, adapte les identifiants :

```php
$host = 'localhost';
$dbname = 'automanager';
$username = 'root';
$password = '';
```

### 4. Initialise les catégories

Exécute `setup_categories.php` une seule fois pour insérer les catégories de base :
```
http://localhost/AutoManager/public/setup_categories.php
```

### 5. Lance le projet localement

Via XAMPP, WAMP, MAMP, Laragon ou tout autre serveur local.

Accède à :  
`http://localhost/AutoManager/public/login.php`

Identifiants par défaut :  
Mot de passe admin : `admin123`

---

## Structure du projet

```
AutoManager/
├── app/
│   ├── controllers/       # Contrôleurs MVC
│   │   └── PieceController.php
│   ├── core/             # Configuration base de données
│   │   └── Database.php  # Singleton PDO
│   ├── models/           # Modèles de données
│   │   └── Piece.php     # Gestion des pièces et catégories
│   └── views/            # Vues HTML
│       ├── piece_list.php    # Liste avec filtres et pagination
│       ├── piece_form.php    # Formulaire ajout/édition
│       ├── header.php        # En-tête (vide)
│       └── footer.php        # Pied de page (vide)
├── database/
│   └── init.sql          # Script SQL (vide)
├── public/               # Point d'entrée web
│   ├── assets/
│   │   └── css/
│   │       └── style.css # Styles personnalisés
│   ├── index.php         # Page principale (protégée)
│   ├── login.php         # Page de connexion
│   ├── logout.php        # Déconnexion
│   └── setup_categories.php # Script d'initialisation
├── Automanager.png       # Capture d'écran
└── README.md            # Ce fichier
```

---

## Sécurité

- Utilisation de PDO avec requêtes préparées
- Protection contre les injections SQL
- Sessions PHP pour l'authentification
- Mot de passe hashé avec `password_hash()`
- Validation des données côté serveur
- Protection CSRF native avec sessions

---

## Aperçu

![Aperçu de l'application](Automanager.png)

---

## Fonctionnalités détaillées

### Gestion des pièces
- **Ajouter** : Formulaire complet avec catégories
- **Modifier** : Édition de tous les champs
- **Supprimer** : Avec confirmation JavaScript
- **Visualiser** : Liste paginée avec indicateurs

### Filtres et recherche
- **Par catégorie** : Dropdown dynamique
- **Par nom** : Recherche textuelle
- **Tri** : Prix ou stock (croissant/décroissant)
- **Pagination** : 5 pièces par page

### Catégories disponibles
- Moteur
- Carrosserie
- Freinage
- Électricité
- Outillage
- Pneumatique
- Suspension

---

## Améliorations possibles

- Gestion des images pour les pièces
- Export CSV/PDF de l'inventaire
- Historique des modifications
- Multi-utilisateurs avec rôles
- API REST pour intégration
- Statistiques et tableaux de bord
- Notifications email stock faible

---

## Contexte

Projet personnel réalisé pour pratiquer PHP et l'architecture MVC.

---

## Auteur

Projet réalisé par **AJOUIRJA Ayoub**
