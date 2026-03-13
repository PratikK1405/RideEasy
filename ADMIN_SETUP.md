# RideEasy Admin Setup Guide

## Can't Log In? Follow These Steps:

### Step 1: Run Database Migration
1. Open: **http://localhost/RideEasy/database/run_migration.php**
2. This adds password reset columns to the admin table
3. Delete `database/run_migration.php` after use

### Step 2: Create/Reset Admin Account
1. Open: **http://localhost/RideEasy/create_admin.php**
2. Enter username, password (min 6 chars), and email
3. Click "Create / Reset Admin"
4. Delete `create_admin.php` after use (security!)

### Step 3: Login
1. Go to: **http://localhost/RideEasy/admin/**
2. Use your username and password

### Forgot Password?
1. On the login page, click **Forgot Password?**
2. Enter your username or email
3. Copy the reset link shown and open it in your browser
4. Set your new password

## Change Database Credentials

**Option A:** Edit `includes/db.php` - change the `DB_PASS`, `DB_USER`, `DB_HOST`, `DB_NAME` values.

**Option B:** Create `includes/db_config.php`:
1. Copy `includes/db_config.sample.php` to `includes/db_config.php`
2. Edit with your MySQL host, user, password, database name

## Fresh Database Install
1. Create database: `rideeasy_db`
2. Import: `database/rideeasy_db.sql` in phpMyAdmin
3. Run migration and create_admin as above
