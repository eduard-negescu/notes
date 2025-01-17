Notes App

Simple Notes Web App written in PHP, using a PostgreSQL DB.
* Supports multiple users.
* User can create, edit and delete notes and rate them by priority (from 1 to 5).
* Admin Page for the administration of the users with a bar chart of the created notes.
  
# Installation
* DON'T EDIT .env. It won't work after.
* Run *docker-compose up* or *podman-compose up* to create the postgres container.
* Run ./init_db.sh if you are on Linux or, maybe Mac, to initialize the db with the users and notes tables and the admin user. It might work on the latter too. If you are on Windows ¯\_(ツ)_/¯, maybe try WSL or something.
* Run *php -S localhost:8000* in the src folder, or set up nginx or apache with php-fpm... or use XAMPP, or MAMP, or WAMP...
