# Laravel RESTful API

## Prerequisites
- PHP 7.4 or higher
- MySQL database
- Redis
- Composer

## Installation
1. Clone the repository to your local machine
2. Navigate to the project folder in your terminal
3. Run `composer install` to install the dependencies
4. Create a .env file in the root of your project and configure your database, Redis and newsData.io API credentials. You can also use .env.exemple file
5. Run `php artisan migrate` to run the migrations and setup the database schema
6. Run `php artisan db:seed` to seed the database with sample data

## Running the API
1. Run `php artisan serve` to start the built-in PHP development server
2. Your API will now be accessible at `http://localhost:8000`

> Note: Make sure your Redis and MySQL servers are running before starting the development server.

## Testing the Endpoints
1. Run `php artisan test` to run the unit tests, there are only few unit test available, just to show how it worts in the API
2. Alternatively, you can use a tool like Postman to send requests to the API and test the endpoints manually

## API Endpoints
The API has the following endpoints

- Retrieve a list of all countries: 
`GET` `/countries`
- Retrieve a selected country by the given country code: 
`GET` `/countries/{code}`
- Add a new country category: 
`POST` `/countries/{code}/categories/{categoryName}`
- Remove country category: 
`DELETE` `/countries/{code}/categories/{categoryName}`
- Retrieve news data from newsData.io API depending on given country, language and category: 
`GET` `/news/{countryCode}/{languageCode}/{category}/{page?}`
- Retrieve news data from newsData.io API depending on given country. This endpoint will use the database information associated with the country to request: 
`GET` `/country-news/{countryCode}/{page?}` 

> Note: The `{page?}` parameter in the GET endpoints is optional and used for pagination.
