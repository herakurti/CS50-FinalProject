# CS50-FinalProject
# Code & Play Hub

## Overview
Code & Play Hub is a simple web application that allows users to create an account, log in, and explore basic coding-related games. The project was created for the CS50 Final Project and is designed to run in any environment that supports PHP and MySQL, including the CS50 IDE. The platform uses a clean directory structure, a minimal interface, and a straightforward authentication flow so that users can quickly sign up and begin interacting with the system.

## How the Project Is Organized
The project is divided into three main folders. The `app` folder contains the backend logic, including database configuration, helper functions, authentication, and game-related code. The `public` folder holds the pages that users interact with, such as the login page, registration page, dashboard, and profile page. Finally, the `sql` folder includes the `schema.sql` file, which contains all of the SQL needed to create the database tables used by the application. Together, these folders form a lightweight structure that keeps code organized and easy to navigate.

## Requirements and Setup
To run the project, you only need PHP, MySQL, and a basic web server such as Apache or the one built into the CS50 IDE. After unzipping or cloning the project, the first step is to create the database by running the SQL file located in the `sql` directory. In MySQL, this is done by executing `SOURCE sql/schema.sql;`. Once the database is created, you should open the `app/config/db.php` file and update the database name, username, and password if necessary. After this, simply start your web server and open the `public` folder in your browser.

## Using the Application
When the application is running, you can begin by creating a new account on the registration page. After registering, you can log in with your credentials and access the dashboard, where the application lists any active games stored in the database. You can also visit your profile page to view your account details. The project is intentionally simple, focusing on user authentication and database-driven content as its main features.

## Troubleshooting
If the site cannot connect to the database, the issue is almost always related to the credentials in `db.php` or the database not being created. Make sure the SQL schema has been imported and that MySQL is running. If any page appears blank, enabling PHP error reporting can quickly reveal the issue.

## Conclusion
Code & Play Hub is intended to be a clean, easy-to-run demonstration of PHP sessions, authentication, SQL integration, and basic web navigation. The project’s small size and simple layout make it easy to extend with new games or additional features.
