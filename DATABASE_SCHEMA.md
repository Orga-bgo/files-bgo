# Database Schema Documentation

## Overview

This document describes the database schema for the BabixGO Files download portal. The application uses MySQL/MariaDB with utf8mb4 character encoding.

## Tables

### 1. users

Stores user account information.

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    description TEXT,
    role ENUM('member', 'admin') DEFAULT 'member',
    comment_count INT DEFAULT 0,
    email_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(64),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Fields:**
- `id`: Primary key, auto-incremented
- `username`: Unique username (3-50 characters)
- `email`: Unique email address
- `password`: Bcrypt hashed password (cost: 12)
- `description`: Optional user profile description
- `role`: User role (member or admin)
- `comment_count`: Cached count of user's comments
- `email_verified`: Whether email has been verified (0 or 1)
- `verification_token`: Token for email verification
- `created_at`: Account creation timestamp

**Indexes:**
- Primary key on `id`
- Unique index on `username`
- Unique index on `email`
- Index on `role` for admin queries

### 2. categories

Stores download categories for organization.

```sql
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(255),
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Fields:**
- `id`: Primary key, auto-incremented
- `name`: Category display name (unique)
- `slug`: URL-friendly identifier (unique)
- `description`: Category description
- `icon`: Optional icon identifier (currently unused)
- `sort_order`: Display order (lower numbers first)
- `created_at`: Creation timestamp

**Indexes:**
- Primary key on `id`
- Unique index on `name`
- Unique index on `slug`
- Index on `sort_order` for sorting

**Default Categories:**
1. Scripts (slug: scripts)
2. Freundschaftsbalken - Android (slug: freundschaftsbalken-android)
3. Freundschaftsbalken - Windows (slug: freundschaftsbalken-windows)

### 3. downloads

Stores downloadable files and their metadata.

```sql
CREATE TABLE downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    file_size VARCHAR(50),
    file_type VARCHAR(10),
    download_link VARCHAR(512) NOT NULL,
    alternative_link VARCHAR(512),
    download_count INT DEFAULT 0,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category_id (category_id),
    INDEX idx_created_by (created_by),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Fields:**
- `id`: Primary key, auto-incremented
- `category_id`: Foreign key to categories table (nullable)
- `name`: Download name/title
- `description`: Download description
- `file_size`: Human-readable file size (e.g., "25 MB")
- `file_type`: File extension (apk, zip, pdf, exe, dmg, etc.)
- `download_link`: Primary download URL (required)
- `alternative_link`: Alternative/backup download URL (optional)
- `download_count`: Number of times downloaded
- `created_by`: Foreign key to users table (nullable)
- `created_at`: Creation timestamp
- `updated_at`: Last update timestamp

**Indexes:**
- Primary key on `id`
- Index on `category_id` for category queries
- Index on `created_by` for user queries
- Index on `created_at` for sorting

**Foreign Keys:**
- `category_id` → `categories(id)` (SET NULL on delete)
- `created_by` → `users(id)` (SET NULL on delete)

**Allowed File Types:**
- apk, zip, pdf, exe, dmg, tar, gz, 7z, rar

**Maximum Upload Size:**
- 100 MB (configurable in config.php)

### 4. comments

Stores user comments on downloads.

```sql
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    download_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_download_id (download_id),
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (download_id) REFERENCES downloads(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Fields:**
- `id`: Primary key, auto-incremented
- `download_id`: Foreign key to downloads table (required)
- `user_id`: Foreign key to users table (required)
- `comment_text`: Comment content (max 2000 characters)
- `created_at`: Comment creation timestamp

**Indexes:**
- Primary key on `id`
- Index on `download_id` for download queries
- Index on `user_id` for user queries
- Index on `created_at` for sorting

**Foreign Keys:**
- `download_id` → `downloads(id)` (CASCADE on delete)
- `user_id` → `users(id)` (CASCADE on delete)

**Constraints:**
- Comment text cannot be empty
- Maximum length: 2000 characters

## Relationships

```
users (1) ──┬─── (N) downloads (created_by)
            └─── (N) comments (user_id)

categories (1) ─── (N) downloads (category_id)

downloads (1) ─── (N) comments (download_id)
```

## Common Queries

### Get all downloads with category and creator info
```sql
SELECT d.*, u.username as creator_name, c.name as category_name,
       (SELECT COUNT(*) FROM comments WHERE download_id = d.id) as comment_count
FROM downloads d
LEFT JOIN users u ON d.created_by = u.id
LEFT JOIN categories c ON d.category_id = c.id
ORDER BY d.created_at DESC;
```

### Get downloads by category
```sql
SELECT d.*, u.username as creator_name,
       (SELECT COUNT(*) FROM comments WHERE download_id = d.id) as comment_count
FROM downloads d
LEFT JOIN users u ON d.created_by = u.id
WHERE d.category_id = ?
ORDER BY d.created_at DESC;
```

### Get comments for a download
```sql
SELECT c.*, u.username
FROM comments c
JOIN users u ON c.user_id = u.id
WHERE c.download_id = ?
ORDER BY c.created_at DESC;
```

### Get dashboard statistics
```sql
-- Total downloads and download count
SELECT COUNT(*) as count, SUM(download_count) as total_downloads
FROM downloads;

-- Total users
SELECT COUNT(*) as count FROM users;

-- Total comments
SELECT COUNT(*) as count FROM comments;
```

## Security Considerations

1. **SQL Injection Prevention**: All queries use prepared statements via `executeQuery()`, `fetchOne()`, and `fetchAll()` helper functions.

2. **XSS Prevention**: All output is escaped using the `e()` function which wraps `htmlspecialchars()`.

3. **Password Security**: Passwords are hashed using `password_hash()` with bcrypt (cost: 12) and verified with `password_verify()`.

4. **CSRF Protection**: Forms include CSRF tokens validated via `validateCsrfToken()`.

5. **Foreign Key Constraints**: Maintain referential integrity and handle cascading deletes appropriately.

## Installation

### Initial Setup

1. Create MySQL/MariaDB database:
```sql
CREATE DATABASE babixgo_files CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Configure database credentials in `.env` file or environment variables:
```env
DB_HOST=localhost
DB_NAME=babixgo_files
DB_USER=your_user
DB_PASSWORD=your_password
```

3. Run the categories installation script:
   - Access: `https://your-domain.com/install.php`
   - This creates the categories table and adds initial categories
   - **Important**: Delete install.php after installation

### Migration Notes

The install.php script handles:
- Creating the `categories` table
- Adding `category_id` column to existing `downloads` table
- Adding necessary indexes and foreign keys
- Inserting default categories

**Note**: The base tables (users, downloads, comments) must already exist before running install.php.

## Maintenance

### Rebuilding Comment Counts

If comment counts get out of sync:
```sql
UPDATE users u
SET comment_count = (
    SELECT COUNT(*)
    FROM comments c
    WHERE c.user_id = u.id
);
```

### Cleaning Up Orphaned Records

While foreign keys handle most cleanup automatically, you can manually verify:
```sql
-- Find downloads without categories (expected to be NULL)
SELECT * FROM downloads WHERE category_id IS NOT NULL AND category_id NOT IN (SELECT id FROM categories);

-- Find downloads without creators (expected to be NULL)
SELECT * FROM downloads WHERE created_by IS NOT NULL AND created_by NOT IN (SELECT id FROM users);
```

## Performance Optimization

1. **Indexes**: All frequently queried columns have indexes
2. **Denormalization**: `comment_count` cached in users table
3. **Efficient Queries**: Use LEFT JOIN instead of subqueries where possible
4. **Pagination**: Implement LIMIT/OFFSET for large result sets

## Backup Strategy

Recommended backup approach:
```bash
# Full database backup
mysqldump -u username -p babixgo_files > backup_$(date +%Y%m%d).sql

# Backup with compression
mysqldump -u username -p babixgo_files | gzip > backup_$(date +%Y%m%d).sql.gz
```

## Future Enhancements

Potential schema improvements:
- Add `downloads.status` field for draft/published states
- Add `downloads.featured` boolean for highlighting content
- Add `categories.parent_id` for nested categories
- Add `download_likes` table for user ratings
- Add `download_views` table for analytics
- Add full-text search indexes for better search performance
