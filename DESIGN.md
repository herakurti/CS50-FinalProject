# DESIGN.md

## Overview
Code & Play Hub was built as a small but structured PHP web application that demonstrates user authentication, session handling, and database interaction. The main goal behind the design was to create a clean and understandable project rather than a complex one. The application uses a basic MVC-inspired layout, separating backend logic, configuration, and user-facing pages so that the project remains organized and easy to expand.

## Application Structure
The structure of the project is intentional. All backend logic lives inside the `app` directory, where the database configuration, helper functions, authentication logic, and game retrieval functions are located. Keeping these pieces grouped together makes it easier to manage functionality without cluttering the user-facing pages. Meanwhile, the `public` directory contains the actual PHP pages users visit. These pages stay relatively simple because they rely on functions from the `app` folder instead of containing logic themselves. The `sql` folder includes the `schema.sql` file, which defines the structure of all database tables. This setup keeps configuration, logic, and presentation clearly separated.

## Database Design
The database was designed to be straightforward. It contains a table for users, which stores basic account information such as name, email, username, and password. There is also a table for games, which includes a code, a name, and an “active” flag. This makes it easy to show only the games that should currently be available to users. The database uses InnoDB with simple relationships, making it easy to expand later without breaking existing features. The use of PDO in the backend was chosen so the application could use prepared statements, which help protect against SQL injection.

## Authentication and Logic
Authentication in the application is handled through PHP sessions. When a user logs in, their ID and role are stored in the session so that the system can check whether they are authenticated on future pages. The login and registration processes rely on small helper functions in `auth.php`, which validate user data and query the database accordingly. Logic related to games is kept separate in its own file, `games.php`, where functions retrieve active games or fetch information about a specific one. Keeping the logic modular makes it easier to add new features later, such as game scoring or additional game types.

## Design Choices
Several decisions were made to keep the project simple and maintainable. The project avoids using large frameworks and instead relies on core PHP so that it remains accessible to beginners. The directory layout was chosen so that it resembles common MVC structure, making the app easier to understand for anyone familiar with web development. The choice to store most logic in separate helper files instead of inside the public pages helps reduce duplication and keeps the code cleaner. The use of prepared statements and sessions follows best practices for PHP security without making the project overly complicated.

## Conclusion
Overall, the design of Code & Play Hub focuses on clarity, simplicity, and room for future expansion. The structure keeps the codebase organized, the database is clean and easy to work with, and the authentication system is simple but reliable. This foundation makes the project suitable both as a working application and as a starting point for more advanced features.
