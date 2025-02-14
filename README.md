# VinyleXplore

VinyleXplore est une application web qui vous aide à choisir un vinyle à écouter en fonction de plusieurs critères et en
apprenant de vos préférences d'écoute.

## Présentation de l'application

VinyleXplore permet de :

- Ajouter des albums vinyles à votre collection.
- Obtenir une recommandation intelligente d’un vinyle à écouter.
- Affiner les recommandations en fonction de vos choix d'écoute.

L'application prend en compte les critères suivants pour vous suggérer un album :

- **Jour de la semaine** (lundi, mardi, …)
- **Moment de la journée** (matin, après-midi, soir…)
- **Lieu d’écoute** (chez soi, au travail, en voiture…)
- **Saison actuelle** (printemps, été, automne, hiver)
- **Humeur** (motivé, paisible, en soirée, romantique, triste, énervé…)

Chaque interaction permet au système d’apprentissage automatique d'améliorer la pertinence des suggestions au fil du
temps.

---

## Pré-requis

Avant d'installer VinyleXplore, assurez-vous d'avoir les éléments suivants installés sur votre machine :

### Backend (Symfony)

- PHP 8.2+
- Composer
- PostgreSQL
- Symfony CLI (facultatif, mais recommandé)

### Service Machine Learning (Python)

- Python 3.10+
- pip (gestionnaire de paquets)
- FastAPI
- Scikit-learn / TensorFlow (selon le moteur de recommandation utilisé)

### Outils additionnels

- Docker (optionnel pour exécuter l’environnement dans des conteneurs)

---

## Installation

### 1. Cloner le projet

```bash
git clone [url_du_referentiel]
cd vinylexplore
```

### 2. Installation du backend Symfony

```bash
cd backend
composer install
```

Créer un fichier .env.local en copiant .env et configurer l'accès à la base de données PostgreSQL :

```dotenv
DATABASE_URL="postgresql://user:password@127.0.0.1:5432/sf_vinylexplore_new?serverVersion=16&charset=utf8"
```

Créer la base de données et exécuter les migrations :

```bash
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
```

Lancer le serveur Symfony :

```bash
symfony serve
```

### 3. Installation du service Machine Learning (Python)

```bash
cd ml-service
pip install -r requirements.txt
```

Lancer le service FastAPI :

```bash
uvicorn main:app --reload
```

### 4. Lancer l'application

Une fois le backend et le service ML en cours d’exécution, vous pouvez accéder à l’application à l’adresse suivante :

http://localhost:8000 (Interface Symfony)
http://localhost:8001/docs (API Machine Learning - Swagger UI)

---

## Développement & Contribution

Si vous souhaitez contribuer au projet :

1. Forkez le dépôt
2. Créez une branche pour votre fonctionnalité (git checkout -b feature/ma-fonctionnalite)
3. Développez et testez vos modifications
4. Faites une Pull Request 🚀

---

## Licence

Ce projet est sous licence MIT. Vous êtes libre de le modifier et de le redistribuer sous les mêmes conditions.

---

## Contact

Si vous avez des questions ou suggestions, n’hésitez pas à nous contacter
à [hello@nicolasvauche.net](mailto:hello@nicolasvauche.net).
