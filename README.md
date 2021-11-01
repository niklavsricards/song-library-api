# Song Library REST API using Symfony

Provides REST API endpoints for crud operations in [this](https://github.com/niklavsricards/song-library-vue) Vue.js app.

## Project setup

1. Go to root directory and run `composer install`
2. Update .env file for connection to your database
3. Run `php bin/console doctrine:migrations:migrate` to create database tables based on project schema
4. Run the project with port 8000 - `symfony server:start --port=8000`
5. Open [localhost:8000](http://localhost:8000) in your browser. If you see symfony welcome page then everything is setup correctly.
