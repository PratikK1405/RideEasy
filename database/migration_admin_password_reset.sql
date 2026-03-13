-- Migration: Admin login fixes & Forgot Password support
-- Run this in phpMyAdmin or MySQL: USE rideeasy_db; then run the statements below

-- Add password reset columns to admin table (skip if columns exist)
ALTER TABLE admin ADD COLUMN reset_token VARCHAR(255) NULL;
ALTER TABLE admin ADD COLUMN reset_token_expires DATETIME NULL;
-- If you get "Duplicate column" error, columns already exist - ignore

-- Fix bikes.size column for engine capacity (50cc, 125cc, 500cc+)
ALTER TABLE bikes MODIFY COLUMN size VARCHAR(20);

-- Ensure admin table has at least one user (run create_admin.php first, or manually):
-- INSERT INTO admin (username, password, email) VALUES 
-- ('admin', '$2y$10$YourHashedPasswordHere', 'admin@rideeasy.com');
-- Use create_admin.php to generate proper password hash
