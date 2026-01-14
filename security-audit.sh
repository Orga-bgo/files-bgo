#!/bin/bash

# Security Audit Script for BabixGO Files
# Run this to verify security measures are in place
# DELETE THIS FILE AFTER AUDIT!

echo "🔒 BabixGO Files - Security Audit"
echo "=================================="
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

passed=0
failed=0
warnings=0

# Function to print results
print_check() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✓${NC} $2"
        ((passed++))
    else
        echo -e "${RED}✗${NC} $2"
        ((failed++))
    fi
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
    ((warnings++))
}

echo "1. Checking for SQL Injection Protection..."
echo "-------------------------------------------"

# Check for direct SQL queries without prepared statements
unsafe_queries=$(grep -r "\$conn->query(\$" public/ --include="*.php" 2>/dev/null | grep -v install.php | wc -l)
print_check $unsafe_queries "No unsafe SQL queries found (excluding install.php)"

# Check for mysql_query (deprecated)
deprecated_mysql=$(grep -r "mysql_query\|mysqli_query" public/ --include="*.php" 2>/dev/null | grep -v "//.*mysql_query" | wc -l)
print_check $deprecated_mysql "No deprecated mysql_query usage"

echo ""
echo "2. Checking for XSS Protection..."
echo "----------------------------------"

# Check for unescaped echo statements (should use e() function)
# This is a heuristic check - may have false positives
unescaped_echo=$(grep -rn "echo.*\$_\|<?=.*\$_" public/ --include="*.php" | grep -v "e(" | grep -v "// " | wc -l)
if [ $unescaped_echo -eq 0 ]; then
    print_check 0 "No obvious unescaped user input in output"
else
    print_warning "Found $unescaped_echo potential unescaped outputs - manual review needed"
fi

echo ""
echo "3. Checking CSRF Protection..."
echo "-------------------------------"

# Check for forms with POST method
forms_with_post=$(grep -r "method=\"post\"\|method='post'" public/ --include="*.php" | wc -l)
csrf_tokens=$(grep -r "csrf_token\|validateCsrfToken" public/ --include="*.php" | wc -l)

if [ $forms_with_post -gt 0 ] && [ $csrf_tokens -gt 0 ]; then
    print_check 0 "CSRF tokens found in forms"
else
    print_warning "Forms found but CSRF protection might be missing - manual review needed"
fi

echo ""
echo "4. Checking Password Security..."
echo "---------------------------------"

# Check for password_hash usage
password_hash_count=$(grep -r "password_hash" public/ --include="*.php" | wc -l)
if [ $password_hash_count -gt 0 ]; then
    print_check 0 "password_hash() function used"
else
    print_warning "password_hash() not found - manual review of auth system needed"
fi

# Check for password_verify usage
password_verify_count=$(grep -r "password_verify" public/ --include="*.php" | wc -l)
if [ $password_verify_count -gt 0 ]; then
    print_check 0 "password_verify() function used"
else
    print_warning "password_verify() not found - manual review needed"
fi

# Check for weak hash algorithms (md5, sha1 for passwords - BAD)
weak_hash=$(grep -rn "md5(\$.*password\|sha1(\$.*password" public/ --include="*.php" | wc -l)
print_check $weak_hash "No weak password hashing algorithms (md5/sha1)"

echo ""
echo "5. Checking File Permissions..."
echo "--------------------------------"

# Check if sensitive files have appropriate permissions
if [ -f "public/.env" ]; then
    env_perms=$(stat -c "%a" public/.env 2>/dev/null || stat -f "%A" public/.env 2>/dev/null)
    if [ "$env_perms" = "600" ] || [ "$env_perms" = "640" ]; then
        print_check 0 ".env file has secure permissions ($env_perms)"
    else
        print_warning ".env file permissions are $env_perms (should be 600 or 640)"
    fi
else
    echo "  ℹ .env file not found (using environment variables)"
fi

echo ""
echo "6. Checking Sensitive File Exposure..."
echo "---------------------------------------"

# Check .htaccess for .env protection
if [ -f "public/.htaccess" ]; then
    env_protection=$(grep -c "\.env" public/.htaccess)
    if [ $env_protection -gt 0 ]; then
        print_check 0 ".htaccess protects .env files"
    else
        print_warning ".htaccess doesn't explicitly block .env - might be protected by default deny"
    fi
fi

# Check for exposed backup files
backup_files=$(find public/ -name "*.bak" -o -name "*.backup" -o -name "*.sql" -o -name "*~" 2>/dev/null | wc -l)
print_check $backup_files "No backup files in public directory"

echo ""
echo "7. Checking Debug Mode..."
echo "-------------------------"

# Check if DEBUG_MODE is disabled in production
if [ -f "public/.env" ]; then
    debug_enabled=$(grep "DEBUG_MODE.*true\|DEBUG_MODE.*1" public/.env 2>/dev/null | wc -l)
    if [ $debug_enabled -eq 0 ]; then
        print_check 0 "DEBUG_MODE is disabled in .env"
    else
        print_warning "DEBUG_MODE is ENABLED - should be disabled in production!"
    fi
fi

# Check for display_errors in PHP files
display_errors=$(grep -r "display_errors.*1" public/ --include="*.php" | grep -v "DEBUG_MODE" | wc -l)
if [ $display_errors -gt 0 ]; then
    print_warning "Found $display_errors files with display_errors enabled"
fi

echo ""
echo "8. Checking Session Security..."
echo "--------------------------------"

# Check for session security settings
session_security=$(grep -r "session.cookie_httponly\|session.cookie_secure" public/ --include="*.php" | wc -l)
if [ $session_security -gt 0 ]; then
    print_check 0 "Session security settings found"
else
    print_warning "Session security settings not found - manual review needed"
fi

echo ""
echo "9. Checking for Diagnostic Files..."
echo "------------------------------------"

# Check for diagnostic/test files that should be deleted
diagnostic_files=0
if [ -f "public/db-diagnostic.php" ]; then
    print_warning "db-diagnostic.php still exists - DELETE IT!"
    diagnostic_files=$((diagnostic_files + 1))
fi

if [ -f "public/add-sample-downloads.php" ]; then
    print_warning "add-sample-downloads.php still exists - DELETE IT!"
    diagnostic_files=$((diagnostic_files + 1))
fi

if [ -f "public/DIAGNOSTIC_GUIDE.md" ]; then
    print_warning "DIAGNOSTIC_GUIDE.md still exists - DELETE IT!"
    diagnostic_files=$((diagnostic_files + 1))
fi

if [ -f "public/install.php" ]; then
    if [ -f ".installed" ]; then
        print_warning "install.php still exists after installation - DELETE IT!"
        diagnostic_files=$((diagnostic_files + 1))
    fi
fi

if [ $diagnostic_files -eq 0 ]; then
    print_check 0 "No diagnostic files found"
fi

echo ""
echo "10. Checking Database Configuration..."
echo "---------------------------------------"

# Check if database credentials are hardcoded (BAD)
hardcoded_db=$(grep -rn "mysqli.*localhost.*root\|new mysqli(.*localhost" public/ --include="*.php" | grep -v "DB_HOST\|getenv" | wc -l)
print_check $hardcoded_db "No hardcoded database credentials"

echo ""
echo "=================================="
echo "📊 SECURITY AUDIT SUMMARY"
echo "=================================="
echo -e "${GREEN}Passed:${NC}   $passed"
echo -e "${RED}Failed:${NC}   $failed"
echo -e "${YELLOW}Warnings:${NC} $warnings"
echo ""

if [ $failed -eq 0 ] && [ $warnings -eq 0 ]; then
    echo -e "${GREEN}✓ All security checks passed!${NC}"
    echo "Your application appears to be secure."
elif [ $failed -eq 0 ]; then
    echo -e "${YELLOW}⚠ Security audit passed with warnings${NC}"
    echo "Review the warnings above and fix them if needed."
else
    echo -e "${RED}✗ Security issues found!${NC}"
    echo "Please address the failed checks before deploying to production."
fi

echo ""
echo "Note: This is an automated audit and may not catch all security issues."
echo "Always perform manual security reviews and penetration testing."
echo ""
echo "🔒 DELETE THIS FILE (security-audit.sh) AFTER USE!"
echo ""
