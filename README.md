# Gestion des Employés

Ce projet est une application web développée pour la **gestion des employés** dans un environnement professionnel. Il permet d'administrer les utilisateurs, les rôles, et les permissions de manière efficace. Le projet a été réalisé en utilisant **Symfony**, **MySQL**, **Twig**, **Docker**, **Git**, et **GitHub**.

---

## 📸 Aperçu

![Aperçu du Projet](lien-vers-une-image-d-aperçu.png)  
*(Remplacez ce texte par un lien vers une capture d'écran de votre projet.)*

---

## 🚀 Fonctionnalités

- **Gestion des utilisateurs** :
  - Ajout, modification, suppression des employés.
  - Attribution de rôles et de permissions.
- **Gestion des rôles** :
  - Création de rôles personnalisés.
  - Attribution de permissions spécifiques à chaque rôle.
- **Interface administrateur** :
  - Tableau de bord pour visualiser et gérer les employés.
  - Gestion des permissions et des accès.
- **Base de données sécurisée** :
  - Utilisation de MySQL pour stocker les données des employés.
  - Sécurité des mots de passe avec hachage.

---

## 🛠 Technologies Utilisées

- **Backend** :
  - ![Symfony](https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=symfony&logoColor=white)
  - ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
  - ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
  - ![Twig](https://img.shields.io/badge/Twig-3F3F3F?style=for-the-badge&logo=twig&logoColor=white)

- **Outils** :
  - ![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
  - ![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)
  - ![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)

---

## 🚀 Comment Exécuter le Projet Localement

Suivez ces étapes pour exécuter le projet sur votre machine locale :

### Prérequis

- Docker et Docker Compose installés.
- Git installé.

### Étapes

1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/fatima236/gestion-employes.git
   cd gestion-employes
   Démarrer les conteneurs Docker :

2.bash
Copy
docker-compose up -d
Installer les dépendances Composer :

3.bash
Copy
docker-compose exec php composer install
Configurer la base de données :

Créez la base de données :

4.bash
Copy
docker-compose exec php bin/console doctrine:database:create
Exécutez les migrations :

5.bash
Copy
docker-compose exec php bin/console doctrine:migrations:migrate
Charger les données de test (optionnel) :

6.bash
Copy
docker-compose exec php bin/console doctrine:fixtures:load
Accéder à l'application :
Ouvrez votre navigateur et accédez à http://localhost:8080.


📝 Licence
Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.

🙌 Contribution
Les contributions sont les bienvenues ! Si vous souhaitez contribuer, veuillez suivre ces étapes :

Forkez le projet.

Créez une branche pour votre fonctionnalité (git checkout -b feature/NouvelleFonctionnalité).

Committez vos changements (git commit -m 'Ajouter une nouvelle fonctionnalité').

Pushez la branche (git push origin feature/NouvelleFonctionnalité).

Ouvrez une Pull Request.

📧 Contact
Si vous avez des questions ou des suggestions, n'hésitez pas à me contacter :

Nom : Fatima Zahra BOUAYADI

Email : fatimazahrabouayadi96@gmail.com

LinkedIn : Fatima Zahra BOUAYADI

GitHub : fatima236

Merci d'avoir visité ce projet ! 😊

