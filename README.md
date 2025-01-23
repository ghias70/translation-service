# translation-service
 
Translations API

This API manages translations for multiple locales .

Quick Setup Instructions

Clone Repository:

git clone <repository-url>
cd translations-api

Install Dependencies:

composer install

Set Up Environment:

Copy .env.example to .env.

Update .env with your database credentials.

Run Migrations and Seed Data:

php artisan migrate
php artisan db:seed --class=TranslationSeeder

Start Server:

php artisan serve

Access the API at http://127.0.0.1:8000.

Key API Endpoints

Method

Endpoint

Description

GET

/translations

Search translations.

POST

/translations

Create a new translation.

PUT

/translations/{id}

Update a translation.



GET

/translations-export

Export translations in JSON format.