---
applyTo: "**/*.php"
---

# PHP-Specific Instructions

## Code Quality

- Use strict type declarations: `declare(strict_types=1);` at the top of new files when appropriate
- Type hint all function parameters and return types
- Use nullable types (`?Type`) when values can be null
- Prefer `??` null coalescing operator over ternary for default values

## Security Requirements

- **Critical**: Always use prepared statements for database queries
- **Critical**: Always escape output with `e()` function when rendering user data in HTML
- Validate all user input on the server side (never trust client-side validation)
- Use `filter_input()` for superglobal access when possible
- Implement CSRF protection for forms (check existing patterns)
- Use `password_hash()` for new password hashing, never MD5 or SHA1

## Database Patterns

Use the helper functions from `includes/db.php`:

```php
// Execute query with prepared statement
$result = executeQuery(
    "SELECT * FROM users WHERE id = ?",
    "i",
    [$userId]
);

// Fetch single row
$user = fetchOne(
    "SELECT * FROM users WHERE email = ?",
    "s",
    [$email]
);

// Fetch multiple rows
$users = fetchAll("SELECT * FROM users WHERE active = 1");
```

## Session Management

- Use the `initSession()` function to start sessions
- Check authentication with `isLoggedIn()` or `requireLogin()`
- Store minimal data in sessions
- Regenerate session IDs on privilege escalation

## Email Functionality

- Use the email helper functions from `includes/email.php`
- Always validate email addresses
- Use templates for consistency

## File Organization

- Place includes at the top of files
- Group related functionality together
- Use meaningful function names that describe what they do
- Keep functions focused on a single responsibility

## Documentation

- Add PHPDoc comments for all functions
- Document parameters with `@param`
- Document return values with `@return`
- Add descriptions for complex logic
- Include usage examples for non-obvious functions

## Error Handling

- Check return values from database operations
- Use exceptions for exceptional cases
- Respect the `DEBUG_MODE` constant for error output
- Provide user-friendly error messages in production
