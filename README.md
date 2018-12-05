# ottonova

The fictional company "Ottivo" wants to be able to determine the amount of each employee's vacation days for a given year by running a command line script.

# Requirements

PHP 7.1
Symfony 4.1
Composer
MySQL

## Installation

composer install

Update database configuration in .env file and import database by running

php bin/console doctrine:database:create

php bin/console doctrine:migrations:migrate

## Generating CSV file

php bin/console app:generate-report {year}

Where {year} is the year you want to extract the report.

Example:

php bin/console app:generate-report 2018

A file called data.csv will be generated in the same directory 

## Running unit tests

php bin/phpunit

## Todo
* Writing unit tests for Employee service and Commands
* Error handling