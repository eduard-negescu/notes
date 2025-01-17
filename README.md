Notes App

Simple Notes Web App written in PHP, using a PostgreSQL DB.
* Supports multiple users
* User can create, edit and delete notes and rate them by priority
* Admin Page for the administration of the users with a bar chart of the created notes.
  
#Installation
* Create .env file containing DB_NAME, DB_USER, DB_PASSWORD, DB_PORT, ADMIN_EMAIL, ADMIN_PASSWORD.
* Run 'docker-compose up' or 'podman-compose up' to create the postgres container.
* Run init_db.sh if you are on Linux and maybe Mac, I dunno if it works for the latter, to initialize the db with the users and notes tables and the admin user. If you are on Windows ¯\_(ツ)_/¯.
* Run 'php -S localhost:8000' in the src folder or set up nginx or apache with php-fpm... or use XAMPP, or MAMP, or WAMP.
