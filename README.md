stock_portfolio
===============

Stock Portfolio

A Symfony application that shows Stock portfolio.

Server requirements
===================
PHP 7,
MySQL


Installation
============
After checkout of the master branch, 

edit config file for database name and password

**app/config/parameters.yml**

and run the following commands:

//// Install packages

`composer install`


// Create database

`bin/console doctrine:database:create `

//Create tables

`bin/console doctrine:schema:update --force`



After that open to the url according to your installation path:

**http://localhost/web/app_dev.php/**

Unit Tests
==========

Unit tests can be run by the command:

`./vendor/bin/simple-phpunit`

