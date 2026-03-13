-- Migration: Convert RideEasy from bicycle to scooter/motorcycle rental
-- Run this if you want to add engine capacity column (optional)
-- The existing 'size' column can be repurposed for engine capacity (50cc, 125cc, etc.)
-- The existing 'gears' column: 0 = automatic/CVT (scooters), 4-6 = manual (motorcycles)

-- Update existing bike types to new vehicle types (run only if you have old data to migrate):
-- UPDATE bikes SET type = 'Scooter' WHERE type IN ('City', 'Electric');
-- UPDATE bikes SET type = 'Motorcycle' WHERE type IN ('Mountain', 'Road');
-- UPDATE bikes SET size = '125cc' WHERE size IN ('S', 'M');
-- UPDATE bikes SET size = '150cc' WHERE size IN ('L', 'XL');
