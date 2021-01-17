## ES Tech Group - Eraldo Almeida Vieira - Test Code

## Details

PHP version: 7.3.23
Composer version: 1.10.15
Laravel Framework version: 8.22.1
Bootstrap CSS and JS version: 5
Data base softwares: MySql Workbench and SQLyog Community
GIT - Github - https://github.com/EraldoAV/estechgrouptest
Excel functions = https://docs.laravel-excel.com/3.1/getting-started/
Local server = php artisan serve and XAMPP

**
    Don't forget to configure your .env file before starting
**

**
    May you need to change the memory consume in you php.ini
    (function to import excel needs it
    php.ini -> memory_limit=-1 (128 -> -1)
**

**
    There are some comments throughout the code to explain some functions
**

## Test Description:

Given the attached database and files

- import.csv -This file has references to products, accounts and users
- live_prices.json-this file simulates an external service where you can read dynamic live prices in real time. A price is always related to a product and it could optionally be related to an account.

Please complete what you can of the following tasks:

- 1.Write a script/function to import the prices provided in import.csv -this file has columns with references to each entity -into the prices table
- 2.Read the JSON price file in real-time and do not load it into the database.  This represents a “live pricing” feed.
- 3.Develop an output for the function below. This can be done using JSON api, command line or UI based on your preference.
- - a. get a product price
- - - I. required parameter: product code (can be one or many)
- - - II. optional parameter: account id(one only,ifnull it is a public product pricebeing requested)
- - - III. Pricing logic:
- - - - 1.Pricing taken from the database should allow the lowest price to winfor a product. A product price in the database with no account id is considered a public price and a match for all queries.A product price with an account ID should match exactly and not be used for pricing without an account ID.
- - - - 2.Any price in the JSON (live price) should win over any price in the databaseso long as it is a match for product and account (use null if no account is provided).If there is no match in the JSON pricing file use the database lowest matching price rule.
- - - IV. Output: returns a product sku and product pricevaluein your preferred format.

You can use any technology you want to complete the test, but of course we'd love to see (only if you're comfortable with these):
- •PHP
- •Laravel
- •MySQL Stored procedures
- •VueJS

## What we're interested in?

Performance is a key point of this test. In real world we're dealing with a lot more datathen whatyou'll find in the database/files.
Speed is important, but we also don't want to drain both CPU and RAM of our server for a single request/process.
