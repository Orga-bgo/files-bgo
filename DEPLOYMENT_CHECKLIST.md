# 🚀 BabixGO Files - Deployment Checklist

## Pre-Deployment Checklist

Use this checklist before deploying to production or after making changes.

---

## 1. Environment Configuration ✅

- [ ] `.env` file configured with production credentials
  - [ ] `DB_HOST` set correctly
  - [ ] `DB_NAME` set correctly
  - [ ] `DB_USER` set correctly
  - [ ] `DB_PASSWORD` set correctly (strong password!)
  - [ ] `SMTP_HOST` configured (if using email)
  - [ ] `SMTP_PORT` configured
  - [ ] `SMTP_USER` configured
  - [ ] `SMTP_KEY` configured
  - [ ] `SITE_URL` matches production domain
  - [ ] `DEBUG_MODE=false` (CRITICAL!)

- [ ] Database created with utf8mb4 charset
- [ ] Database user has appropriate permissions
- [ ] SSL/HTTPS certificate installed and working

---

## 2. Database Setup ✅

- [ ] Database tables created (run install.php if needed)
- [ ] Categories table populated with 3 default categories
- [ ] `category_id` column exists in downloads table
- [ ] Foreign keys established
- [ ] At least one admin user exists
- [ ] Test downloads added (or sample data for testing)

### Verify Database
```sql
-- Check tables exist
SHOW TABLES;

-- Check categories
SELECT * FROM categories;

-- Check downloads count
SELECT COUNT(*) FROM downloads;

-- Check admin user
SELECT username, role FROM users WHERE role = 'admin';
```

---

## 3. Security Hardening 🔒

### Files to Delete (CRITICAL!)
- [ ] `install.php` (after installation complete)
- [ ] `db-diagnostic.php` (after diagnostics complete)
- [ ] `add-sample-downloads.php` (after adding data)
- [ ] `DIAGNOSTIC_GUIDE.md` (after reading)
- [ ] `security-audit.sh` (after running)
- [ ] `DEPLOYMENT_CHECKLIST.md` (this file, after completion)

### Security Verification
- [ ] Run `./security-audit.sh` and review results
- [ ] No diagnostic/test files in production
- [ ] `.env` file NOT in git repository
- [ ] `.env` file permissions set to 600 or 640
- [ ] `.htaccess` properly configured
- [ ] HTTPS enabled and enforced
- [ ] Security headers configured in .htaccess

### .htaccess Security
```apache
# Verify these lines exist in .htaccess:
<FilesMatch "\.(htaccess|htpasswd|ini|log|sh|sql|env)$">
    Order Allow,Deny
    Deny from all
</FilesMatch>

# Uncomment to force HTTPS:
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 4. File Permissions 📁

```bash
# Recommended permissions:
chmod 755 public/              # Web root
chmod 644 public/*.php         # PHP files
chmod 644 public/.htaccess     # Apache config
chmod 600 public/.env          # Environment file (if exists)
chmod 755 public/assets/       # Assets directory
chmod 755 public/includes/     # Includes directory
chmod 755 public/admin/        # Admin directory
chmod 755 public/api/          # API directory

# If uploads directory exists:
chmod 755 public/uploads/      # Uploads (writable by web server)
```

---

## 5. Functionality Testing ✅

### Homepage
- [ ] Loads without errors
- [ ] Categories display correctly
- [ ] Download counts are accurate (not all zeros)
- [ ] Footer links work
- [ ] Cookie banner appears (clear localStorage first)
- [ ] Mobile responsive (test 375px, 768px, 1024px)

### Authentication
- [ ] Login works with username
- [ ] Login works with email
- [ ] Logout works
- [ ] Registration works (if enabled)
- [ ] Email verification works (if SMTP configured)
- [ ] Password requirements enforced
- [ ] Rate limiting works (5 failed attempts = 15 min lockout)

### Category Pages
- [ ] `/kategorie/scripts` loads
- [ ] `/kategorie/freundschaftsbalken-android` loads
- [ ] `/kategorie/freundschaftsbalken-windows` loads
- [ ] Downloads display correctly
- [ ] Breadcrumb navigation works
- [ ] Empty state shows when no downloads

### Downloads
- [ ] Download button visible when logged in
- [ ] Login prompt shows when not logged in
- [ ] Download link redirects correctly
- [ ] Download counter increments
- [ ] Alternative links work (if present)

### Admin Panel (if admin)
- [ ] Dashboard loads and shows stats
- [ ] Upload form works
- [ ] Can create new downloads
- [ ] Can edit existing downloads
- [ ] Can delete downloads
- [ ] User management works
- [ ] Comment moderation works

### Mobile Navigation
- [ ] Hamburger menu appears on mobile
- [ ] Menu opens/closes smoothly
- [ ] Dropdowns work
- [ ] Links are accessible
- [ ] Menu closes when clicking outside
- [ ] Menu closes on resize to desktop

### Cookie Banner
- [ ] Appears on first visit
- [ ] "Akzeptieren" hides banner
- [ ] "Ablehnen" hides banner
- [ ] Choice persists on reload
- [ ] Google Analytics loads only if accepted
- [ ] Can reset with `resetCookieConsent()` in console

---

## 6. Performance Optimization ⚡

- [ ] Asset compression enabled in .htaccess
- [ ] Browser caching configured
- [ ] Images optimized
- [ ] CSS/JS minified (optional)
- [ ] Service worker registered (PWA)
- [ ] Google Analytics loads asynchronously

### Performance Test
- [ ] Homepage loads in < 2 seconds
- [ ] Time to Interactive < 3 seconds
- [ ] No console errors in browser DevTools
- [ ] No network errors in Network tab

---

## 7. SEO & Metadata 🔍

- [ ] Page titles descriptive and unique
- [ ] Meta descriptions present
- [ ] Open Graph tags configured
- [ ] Favicon and app icons present
- [ ] `manifest.json` configured correctly
- [ ] `robots.txt` allows indexing (if desired)
- [ ] Sitemap.xml exists (optional)

---

## 8. Monitoring & Analytics 📊

- [ ] Google Analytics configured (if desired)
- [ ] GA_TRACKING_ID environment variable set
- [ ] Analytics consent working correctly
- [ ] Error logging configured
- [ ] Access logs reviewed

---

## 9. Backup Strategy 💾

- [ ] Database backup scheduled (daily recommended)
- [ ] File backup scheduled (weekly recommended)
- [ ] Backup restore tested
- [ ] Offsite backup storage configured

### Database Backup Example
```bash
# Manual backup
mysqldump -u username -p babixgo_files > backup_$(date +%Y%m%d).sql

# Compressed backup
mysqldump -u username -p babixgo_files | gzip > backup_$(date +%Y%m%d).sql.gz

# Automated daily backup (cron)
0 2 * * * mysqldump -u username -p'password' babixgo_files | gzip > /backups/db_$(date +\%Y\%m\%d).sql.gz
```

---

## 10. Documentation 📚

- [ ] README.md reviewed
- [ ] DATABASE_SCHEMA.md reviewed
- [ ] TESTING.md reviewed
- [ ] Admin credentials documented securely
- [ ] Database credentials documented securely
- [ ] Deployment process documented

---

## 11. Legal & Compliance ⚖️

- [ ] Privacy policy (Datenschutz) reviewed
- [ ] Impressum (legal notice) updated
- [ ] GDPR compliance verified
- [ ] Cookie consent functional
- [ ] Data retention policy defined

---

## 12. Final Verification ✨

### Run These Commands
```bash
# 1. Security audit
./security-audit.sh

# 2. Check for sensitive files
find public/ -name "*.bak" -o -name "*.sql" -o -name "*.backup"

# 3. Check git status (nothing sensitive committed)
git status

# 4. Check environment
grep -r "DEBUG_MODE.*true" public/
```

### Manual Checks
- [ ] No errors in PHP error log
- [ ] No errors in Apache/Nginx error log
- [ ] All forms submit without errors
- [ ] All links work (no 404s)
- [ ] SSL certificate valid and not expiring soon
- [ ] Email sending works (test welcome email)

---

## 13. Post-Deployment 🎉

After deployment:

- [ ] Test all functionality on production URL
- [ ] Monitor error logs for first 24 hours
- [ ] Test from different devices (mobile, tablet, desktop)
- [ ] Test from different browsers (Chrome, Firefox, Safari, Edge)
- [ ] Get user feedback
- [ ] Monitor performance
- [ ] Check analytics (if configured)

---

## Quick Troubleshooting 🔧

### Database Connection Failed
1. Check .env file exists and is readable
2. Verify database credentials
3. Test database connection from hosting panel
4. Check database server is running

### "0 Downloads" Issue
1. Run db-diagnostic.php
2. Check downloads table has data
3. Verify category_id is set on downloads
4. Run add-sample-downloads.php for testing

### Cookie Banner Not Working
1. Clear localStorage in browser
2. Check cookie-consent.js is loaded
3. Check for JavaScript errors in console
4. Verify tracking.php has valid GA_TRACKING_ID

### Mobile Menu Not Opening
1. Check header.js is loaded
2. Check for JavaScript errors
3. Verify menu toggle button exists
4. Check CSS is loaded correctly

---

## Success Criteria ✅

Your deployment is successful when:

- ✅ No errors on any page
- ✅ All features working as expected
- ✅ Security audit passes
- ✅ Performance is acceptable
- ✅ Mobile responsive
- ✅ No diagnostic files in production
- ✅ DEBUG_MODE is false
- ✅ HTTPS enabled
- ✅ Backups configured
- ✅ Monitoring in place

---

## Support

If you encounter issues:

1. Check error logs (PHP, Apache/Nginx)
2. Review documentation files
3. Run security-audit.sh
4. Test in incognito mode
5. Check browser console for errors
6. Open GitHub issue with details

---

**Remember:** Delete this file and all diagnostic files after deployment! 🗑️

Good luck! 🚀
