# GitHub Copilot Instructions for BabixGO Files

## Project Overview

BabixGO Files is a PHP-based file download portal for the BabixGO community. The application provides a clean, user-friendly interface for managing and downloading files across different categories.

## Technology Stack

- **Backend**: PHP 8.x with MySQLi
- **Database**: MySQL/MariaDB
- **Frontend**: Vanilla JavaScript, HTML5, CSS3
- **Architecture**: MVC-like structure with separation of concerns
- **PWA**: Progressive Web App support with service workers

## Code Style and Conventions

### General Guidelines

- Write clean, readable code with proper documentation
- Use meaningful variable and function names in English
- Follow existing code patterns and structures in the codebase
- Maintain consistency with the established file organization

### PHP Code Style

- Use PHP type declarations for function parameters and return types
- Follow PSR-12 coding standards where applicable
- Use prepared statements for all database queries (never use raw SQL with user input)
- Use the singleton pattern for database connections (via `getDB()`)
- Sanitize output with the `e()` function to prevent XSS attacks
- Place configuration in environment variables or `.env` files
- Use PHPDoc comments for classes, methods, and complex functions

### Security Best Practices

- **Always** use prepared statements for database queries
- **Always** sanitize HTML output using the `e()` function
- Validate and sanitize all user input on the server side
- Use CSRF tokens for state-changing operations
- Store passwords using `password_hash()` and verify with `password_verify()`
- Keep sensitive configuration in environment variables
- Never commit `.env` files or credentials to the repository

### Database Conventions

- Use the helper functions from `includes/db.php`:
  - `getDB()` for database connections
  - `executeQuery()` for executing prepared statements
  - `fetchOne()` for single row results
  - `fetchAll()` for multiple rows
- Always use prepared statements with type binding
- Use descriptive table and column names
- Maintain referential integrity with foreign keys

### File Structure

- **public/**: Web-accessible files (entry points)
- **public/includes/**: Core PHP includes (config, auth, db, functions)
- **public/admin/**: Admin panel pages
- **public/api/**: API endpoints
- **public/assets/**: Static assets (CSS, JS, images, icons)

### Frontend Guidelines

- Use vanilla JavaScript (no frameworks)
- Keep JavaScript modular and organized
- Use semantic HTML5 elements
- Ensure responsive design for mobile and desktop
- Follow progressive enhancement principles
- Test PWA functionality when making changes to service workers

### Error Handling

- Use `DEBUG_MODE` constant to control error verbosity
- Show user-friendly error messages in production
- Never expose sensitive information in error messages
- Handle errors gracefully with try-catch blocks where appropriate

## Testing and Validation

- Manually test all user-facing changes
- Verify database queries work correctly
- Test security-sensitive code paths
- Ensure responsive design on different screen sizes
- Test PWA functionality when applicable

## Build and Deployment

- This is a standard PHP application - no build step required
- Deploy by copying files to web server
- Ensure proper file permissions (writable uploads directory)
- Configure environment variables on the server
- Run database migrations if needed

## Common Tasks

### Adding a new page

1. Create the PHP file in the appropriate directory
2. Include `init.php` for core functionality
3. Use the existing header/footer includes
4. Follow the HTML structure from other pages

### Adding a database query

1. Use prepared statements via `executeQuery()`
2. Specify parameter types (s=string, i=integer, d=double, b=blob)
3. Always sanitize output with `e()` when displaying

### Adding an API endpoint

1. Create endpoint in `public/api/`
2. Validate input and check authentication
3. Return JSON responses with appropriate HTTP status codes
4. Handle errors gracefully
