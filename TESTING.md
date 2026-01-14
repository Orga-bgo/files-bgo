# Testing and Verification Checklist

This document provides a comprehensive checklist for testing all features of the BabixGO Files download portal.

## Pre-Deployment Checklist

### Environment Setup
- [ ] Database created with correct charset (utf8mb4)
- [ ] `.env` file configured with correct credentials
- [ ] Database tables created (run install.php if needed)
- [ ] File permissions set correctly (uploads directory writable)
- [ ] SMTP credentials configured (if using email verification)
- [ ] `.htaccess` file uploaded and mod_rewrite enabled
- [ ] SSL certificate installed (HTTPS)

### Configuration Verification
- [ ] `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` set correctly
- [ ] `SMTP_HOST`, `SMTP_PORT`, `SMTP_USER`, `SMTP_KEY` configured (optional)
- [ ] `SITE_URL` matches actual domain
- [ ] `DEBUG_MODE=false` in production environment
- [ ] PHP version >= 7.4 (8.x recommended)
- [ ] MySQL/MariaDB version >= 5.7

## Phase 1: Core Functionality

### 1.1 Homepage (`index.php`)
- [ ] Page loads without errors
- [ ] Categories grid displays correctly
- [ ] Category cards show correct download counts
- [ ] "BabixGO Files" branding displays correctly
- [ ] Footer links work (Impressum, Datenschutz, babixgo.de)
- [ ] No console errors in browser developer tools
- [ ] Page responsive on mobile (test at 375px, 768px, 1024px)

### 1.2 Navigation & Header
- [ ] Header logo links to homepage
- [ ] Mobile menu button appears on small screens
- [ ] Mobile menu opens/closes correctly
- [ ] Mobile menu dropdowns work (if present)
- [ ] Close menu when clicking outside
- [ ] Close menu when resizing to desktop
- [ ] Accessibility: ARIA labels present
- [ ] Keyboard navigation works (Tab, Enter, Escape)

### 1.3 Category Pages (`/kategorie/{slug}`)
- [ ] Category page loads for valid slugs
- [ ] Breadcrumb navigation displays correctly
- [ ] Category description shows
- [ ] Downloads list displays correctly
- [ ] Empty state shows when no downloads
- [ ] Download metadata displays (type, size, count, comments)
- [ ] "Herunterladen" button shows for logged-in users
- [ ] "Anmelden" prompt shows for non-logged-in users
- [ ] Alternative download link works (if present)
- [ ] 404 error for invalid category slugs

## Phase 2: Authentication System

### 2.1 Registration (`register.php`)
- [ ] Registration form displays correctly
- [ ] Username validation (3-50 characters)
- [ ] Email validation (valid email format)
- [ ] Password validation (minimum 8 characters)
- [ ] Password confirmation matches
- [ ] Password strength indicator works
- [ ] Duplicate username/email prevention
- [ ] CSRF token validation
- [ ] Success message after registration
- [ ] Verification email sent (if SMTP configured)
- [ ] Redirect to login after registration

**Test Cases:**
- Invalid username (too short, too long)
- Invalid email format
- Weak password (too short)
- Passwords don't match
- Duplicate username
- Duplicate email

### 2.2 Email Verification (`verify.php`)
- [ ] Verification link from email works
- [ ] Success message after verification
- [ ] Invalid token shows error
- [ ] Already verified token shows error
- [ ] Can login after verification

### 2.3 Login (`login.php`)
- [ ] Login form displays correctly
- [ ] Login with username works
- [ ] Login with email works
- [ ] Incorrect credentials show error
- [ ] Rate limiting after 5 failed attempts (15 min lockout)
- [ ] Unverified email shows error message
- [ ] CSRF token validation
- [ ] Redirect to original page after login
- [ ] Session persists across pages
- [ ] "Remember me" functionality (if implemented)

**Test Cases:**
- Login with username
- Login with email
- Wrong password
- Non-existent user
- Unverified email
- 5+ failed attempts (rate limiting)

### 2.4 Logout (`logout.php`)
- [ ] Logout clears session
- [ ] Logout destroys cookies
- [ ] Redirect to homepage after logout
- [ ] Cannot access protected pages after logout

### 2.5 Profile (`profile.php`)
- [ ] Profile page loads for logged-in users
- [ ] User information displays correctly
- [ ] Profile description editable
- [ ] Profile update works
- [ ] Success message after update
- [ ] Non-logged-in users redirected to login

## Phase 3: Download System

### 3.1 Download Handler (`download.php`)
- [ ] Download increments counter
- [ ] Redirects to correct download link
- [ ] Non-logged-in users redirected to login
- [ ] Invalid download ID shows error
- [ ] Missing download link shows error
- [ ] Download counter updates in database

### 3.2 Comment System
- [ ] Comment form displays on download pages
- [ ] Comment submission via AJAX works
- [ ] Comment appears immediately after submission
- [ ] Comment count updates dynamically
- [ ] Character limit enforced (2000 chars)
- [ ] Empty comments rejected
- [ ] CSRF token validation
- [ ] Comments display with username and timestamp
- [ ] Relative time format works ("vor 2 Stunden")
- [ ] Comments sorted by newest first

**Test Cases:**
- Submit valid comment
- Submit empty comment
- Submit > 2000 character comment
- XSS prevention (try `<script>alert('xss')</script>`)

## Phase 4: Admin Panel

### 4.1 Admin Access
- [ ] Non-admin users redirected from admin pages
- [ ] Admin navigation accessible for admin users
- [ ] Admin pages have noindex meta tag

### 4.2 Admin Dashboard (`/admin/dashboard.php`)
- [ ] Statistics display correctly
  - [ ] Total downloads count
  - [ ] Total download count (sum of all downloads)
  - [ ] Total users count
  - [ ] Total comments count
- [ ] Quick action cards display
- [ ] Links to all admin pages work

### 4.3 Upload Page (`/admin/upload.php`)
- [ ] Upload form displays correctly
- [ ] Category dropdown populated from database
- [ ] File metadata fields (name, description, type, size)
- [ ] Download link validation
- [ ] Alternative link (optional)
- [ ] CSRF token validation
- [ ] Success message after upload
- [ ] New download appears in database
- [ ] New download appears on category page

**Test Cases:**
- Upload with all fields filled
- Upload with only required fields
- Upload with invalid data
- SQL injection prevention

### 4.4 Manage Downloads (`/admin/manage-downloads.php`)
- [ ] All downloads list displays
- [ ] Edit button works for each download
- [ ] Delete button shows confirmation
- [ ] Delete removes download from database
- [ ] Edit form pre-populates with existing data
- [ ] Update saves changes correctly
- [ ] Category reassignment works
- [ ] Pagination works (if implemented)

### 4.5 Manage Users (`/admin/manage-users.php`)
- [ ] All users list displays
- [ ] User information shows correctly
- [ ] Role change dropdown works
- [ ] Role update saves correctly
- [ ] Delete user shows confirmation
- [ ] Delete removes user from database
- [ ] Cannot delete own admin account
- [ ] Cascading deletes work (user's comments deleted)

### 4.6 Moderate Comments (`/admin/moderate-comments.php`)
- [ ] All comments list displays
- [ ] Comment text visible
- [ ] Download name shows for each comment
- [ ] Username shows for each comment
- [ ] Delete button shows confirmation
- [ ] Delete removes comment from database
- [ ] Comment count decreases in user profile

## Phase 5: Progressive Web App (PWA)

### 5.1 Manifest
- [ ] Manifest.json loads without errors
- [ ] All icon sizes present (72, 96, 128, 144, 152, 192, 384, 512)
- [ ] Theme color applies correctly
- [ ] "Add to Home Screen" prompt appears (mobile)
- [ ] App name displays correctly
- [ ] Standalone display mode works

### 5.2 Service Worker
- [ ] Service worker registers successfully
- [ ] Console shows "ServiceWorker registered"
- [ ] Static assets cached on install
- [ ] Dynamic caching works
- [ ] Offline page displays when offline
- [ ] Network-first strategy for HTML pages
- [ ] Cache-first strategy for static assets
- [ ] API requests not cached
- [ ] Admin pages not cached

**Testing Offline Mode:**
1. Load site while online
2. Open DevTools > Application > Service Workers
3. Check "Offline" checkbox
4. Try navigating (should show offline page for new pages)
5. Try loading cached pages (should work)

## Phase 6: Security

### 6.1 SQL Injection Prevention
- [ ] All queries use prepared statements
- [ ] No raw SQL with user input
- [ ] Parameter binding used correctly

**Test Cases:**
- Try `' OR '1'='1` in login username
- Try `1; DROP TABLE users;--` in download ID
- SQL keywords in comment text

### 6.2 XSS Prevention
- [ ] All output escaped with `e()` function
- [ ] User input sanitized before display
- [ ] HTML tags in comments don't execute

**Test Cases:**
- Comment: `<script>alert('XSS')</script>`
- Comment: `<img src=x onerror=alert('XSS')>`
- Username: `<b>Bold Name</b>`

### 6.3 CSRF Protection
- [ ] CSRF tokens generated for forms
- [ ] CSRF tokens validated on submission
- [ ] Invalid CSRF token rejected
- [ ] CSRF token changes per session

**Test Cases:**
- Submit form without CSRF token
- Submit form with old/invalid CSRF token

### 6.4 Authentication & Authorization
- [ ] Protected pages require login
- [ ] Admin pages require admin role
- [ ] Session timeout works (24 hours)
- [ ] Session regeneration works (every 30 min)
- [ ] Secure cookie flags set (HttpOnly, Secure, SameSite)

### 6.5 Rate Limiting
- [ ] Login attempts limited to 5
- [ ] 15-minute lockout after exceeded attempts
- [ ] Lockout message displays correctly
- [ ] Counter resets after lockout period

### 6.6 File Security
- [ ] `.htaccess` blocks access to sensitive files (.env, .sql, .log)
- [ ] `includes/` directory not directly accessible
- [ ] No directory listing enabled

**Test Access:**
- Try accessing `/.env`
- Try accessing `/includes/config.php`
- Try accessing `/includes/` directory

## Phase 7: Performance

### 7.1 Page Load Speed
- [ ] Homepage loads in < 3 seconds
- [ ] Category pages load in < 3 seconds
- [ ] No unnecessary database queries
- [ ] Images optimized (PNG icons < 20KB)
- [ ] CSS minified (or acceptable size)
- [ ] JavaScript minified (or acceptable size)

### 7.2 Browser Caching
- [ ] Static assets cached by browser
- [ ] Cache expiration headers set
- [ ] ETags configured

### 7.3 Database Performance
- [ ] Indexes on frequently queried columns
- [ ] No N+1 query problems
- [ ] Efficient JOIN queries
- [ ] Comment counts cached in users table

### 7.4 Lighthouse Audit
- [ ] Performance score > 80
- [ ] Accessibility score > 90
- [ ] Best Practices score > 90
- [ ] SEO score > 80
- [ ] PWA criteria met

## Phase 8: Cross-Browser Compatibility

### 8.1 Desktop Browsers
- [ ] Chrome/Edge (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest, macOS)

**Test in each browser:**
- Page rendering
- JavaScript functionality
- Form submissions
- Service worker registration

### 8.2 Mobile Browsers
- [ ] Chrome Mobile (Android)
- [ ] Safari Mobile (iOS)
- [ ] Firefox Mobile

**Test on mobile:**
- Touch interactions
- Mobile menu
- PWA installation
- Viewport scaling

## Phase 9: Responsive Design

### 9.1 Breakpoints
Test at these screen widths:
- [ ] 375px (Mobile - iPhone SE)
- [ ] 414px (Mobile - iPhone Pro)
- [ ] 768px (Tablet - iPad)
- [ ] 1024px (Desktop - Small)
- [ ] 1440px (Desktop - Large)

### 9.2 Mobile (< 768px)
- [ ] Navigation collapses to hamburger menu
- [ ] Cards stack vertically
- [ ] Text readable without zooming
- [ ] Buttons large enough to tap (44x44px min)
- [ ] Forms fit on screen
- [ ] No horizontal scrolling

### 9.3 Tablet (768px - 1023px)
- [ ] Layout adjusts appropriately
- [ ] Navigation shows desktop or mobile menu
- [ ] Grid layouts use appropriate columns

### 9.4 Desktop (>= 1024px)
- [ ] Full navigation visible
- [ ] Multi-column layouts display
- [ ] Max-width containers center content
- [ ] No excessive white space

## Phase 10: Accessibility

### 10.1 Keyboard Navigation
- [ ] Tab key navigates through interactive elements
- [ ] Enter activates buttons and links
- [ ] Escape closes modals/menus
- [ ] Focus indicators visible
- [ ] Skip to main content link (if implemented)

### 10.2 Screen Reader Compatibility
- [ ] ARIA labels on interactive elements
- [ ] ARIA-expanded on toggle buttons
- [ ] ARIA-hidden on decorative elements
- [ ] Semantic HTML (header, nav, main, footer)
- [ ] Form labels associated with inputs
- [ ] Alt text on images (if any)

### 10.3 Color Contrast
- [ ] Text meets WCAG AA standards (4.5:1)
- [ ] Large text meets WCAG AA standards (3:1)
- [ ] Interactive elements distinguishable
- [ ] Focus indicators visible

### 10.4 Screen Reader Testing Tools
- [ ] Test with NVDA (Windows)
- [ ] Test with JAWS (Windows)
- [ ] Test with VoiceOver (macOS/iOS)

## Phase 11: Cookie Consent & Analytics

### 11.1 Cookie Banner
- [ ] Banner appears on first visit
- [ ] Banner hidden after 1 second delay
- [ ] Accept button saves consent
- [ ] Decline button saves declined state
- [ ] Banner doesn't show after choice made
- [ ] LocalStorage stores consent choice

### 11.2 Google Analytics
- [ ] GA only loads after consent accepted
- [ ] GA doesn't load if consent declined
- [ ] GA tracking ID configurable via env
- [ ] IP anonymization enabled
- [ ] Cookie flags set correctly (SameSite, Secure)
- [ ] No GA if tracking ID not configured

### 11.3 GDPR Compliance
- [ ] Datenschutz page accessible
- [ ] Privacy policy explains data collection
- [ ] User can decline tracking
- [ ] Consent stored locally, not server-side

## Phase 12: Error Handling

### 12.1 Database Errors
- [ ] Missing DB credentials show helpful error
- [ ] Connection failure shows error page
- [ ] Query errors logged (if DEBUG_MODE)
- [ ] User sees generic error (production)

### 12.2 404 Errors
- [ ] Invalid URLs show 404 page
- [ ] Invalid category slugs show 404
- [ ] Invalid download IDs redirect with error

### 12.3 Form Validation Errors
- [ ] Empty required fields show error
- [ ] Invalid input shows specific error message
- [ ] Errors display near relevant form field
- [ ] Form preserves valid input after error

### 12.4 Server Errors (500)
- [ ] PHP errors don't display (production)
- [ ] Generic error page shows
- [ ] Errors logged to PHP error log

## Phase 13: Email Functionality

### 13.1 Email Sending
- [ ] Verification emails send successfully
- [ ] Email HTML renders correctly
- [ ] Email links work (verification URL)
- [ ] Fallback SMTP works if PHPMailer unavailable
- [ ] Last resort mail() works if SMTP fails

### 13.2 Email Content
- [ ] Subject line correct
- [ ] Recipient correct
- [ ] Sender shows as "BabixGO Files"
- [ ] HTML and plain text versions present
- [ ] Links clickable
- [ ] Styling renders in email clients

## Deployment Checklist

### Pre-Deployment
- [ ] Run all tests on staging environment
- [ ] Backup existing database (if applicable)
- [ ] Review all environment variables
- [ ] Check DEBUG_MODE=false
- [ ] Review .gitignore (don't commit .env)

### Deployment
- [ ] Upload files via SFTP (or use GitHub Actions)
- [ ] Set correct file permissions
- [ ] Verify .htaccess uploaded
- [ ] Verify .env file created with correct values
- [ ] Run install.php if first deployment
- [ ] Delete install.php after installation

### Post-Deployment
- [ ] Test homepage loads
- [ ] Test database connection
- [ ] Test user registration
- [ ] Test email sending
- [ ] Check for PHP errors in logs
- [ ] Verify HTTPS works
- [ ] Test PWA installation
- [ ] Monitor for 24 hours

## Ongoing Monitoring

### Daily Checks
- [ ] Site accessible
- [ ] No PHP errors in logs
- [ ] Database queries executing

### Weekly Checks
- [ ] Review user registrations
- [ ] Check download counts
- [ ] Review comment moderation queue
- [ ] Backup database

### Monthly Checks
- [ ] Update dependencies (if applicable)
- [ ] Review security alerts
- [ ] Lighthouse audit
- [ ] Review analytics

## Known Issues

Document any known issues here:

- None currently identified

## Testing Notes

Add notes from your testing sessions:

- Date:
- Tester:
- Environment:
- Issues Found:
- Resolved:
