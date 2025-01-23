API Laravel pour Bruce Wayne
Ce projet est une API Laravel qui permet à Bruce Wayne de gérer les paniques via une application mobile. L'API est sécurisée avec Laravel Passport et intègre l'API Wayne Enterprises pour envoyer et annuler des paniques.

-----Fonctionnalités-------
-Authentification sécurisée : Utilisation de Laravel Passport pour générer des tokens OAuth2.

-Gestion des paniques :

-Envoyer une panique avec des coordonnées GPS et des détails optionnels.

-Annuler une panique.

-Récupérer l'historique des paniques.

-Intégration avec Wayne Enterprises : Envoi et annulation de paniques via une API externe.

-Journalisation : Toutes les activités de l'API sont enregistrées dans la base de données.

-----Installation------
Cloner le dépôt :
bash
Copy
git clone https://github.com/votre-utilisateur/panic-api.git
cd panic-api

Installer les dépendances :

bash
Copy
-composer install


----Configurer l'environnement :

Copiez le fichier .env.example en .env :

bash
Copy
cp .env.example .env
Configurez les variables d'environnement dans .env :

env
Copy
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=panic_api
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

WAYNE_ENTERPRISES_TOKEN=votre_token_ici
Générer la clé d'application :

bash
Copy
php artisan key:generate
Configurer Laravel Passport :

bash
Copy
php artisan passport:install
Exécuter les migrations et seeders :

bash
Copy
php artisan migrate --seed
Lancer le serveur :

bash
Copy
php artisan serve
Lancer le worker de queue (pour les jobs asynchrones) :

bash
Copy
php artisan queue:work
Utilisation
Endpoints de l'API
