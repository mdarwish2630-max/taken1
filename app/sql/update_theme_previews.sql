-- ====================================
-- تحديث صور بريفيو القوالب
-- Update theme preview images
-- ====================================

-- التأكد من وجود عمود preview_image
SET @dbname = DATABASE();
SET @tablename = 'themes';
SET @columnname = 'preview_image';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_schema = @dbname)
      AND (table_name = @tablename)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' VARCHAR(500) NULL AFTER description_en')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- التأكد من وجود عمود thumbnail
SET @columnname2 = 'thumbnail';
SET @preparedStatement2 = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_schema = @dbname)
      AND (table_name = @tablename)
      AND (column_name = @columnname2)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname2, ' VARCHAR(500) NULL AFTER preview_image')
));
PREPARE alterIfNotExists2 FROM @preparedStatement2;
EXECUTE alterIfNotExists2;
DEALLOCATE PREPARE alterIfNotExists2;

-- تحديث صور البريفيو لكل قالب
UPDATE themes SET preview_image = 'themes/previews/cleaning-preview.png', thumbnail = 'themes/previews/cleaning-preview.png' WHERE slug = 'cleaning' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/electric-preview.png', thumbnail = 'themes/previews/electric-preview.png' WHERE slug = 'electric' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/restaurant-preview.png', thumbnail = 'themes/previews/restaurant-preview.png' WHERE slug = 'restaurant' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/medical-preview.png', thumbnail = 'themes/previews/medical-preview.png' WHERE slug = 'medical' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/realestate-preview.png', thumbnail = 'themes/previews/realestate-preview.png' WHERE slug = 'realestate' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/education-preview.png', thumbnail = 'themes/previews/education-preview.png' WHERE slug = 'education' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/general-preview.png', thumbnail = 'themes/previews/general-preview.png' WHERE slug = 'general' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/decor-preview.png', thumbnail = 'themes/previews/decor-preview.png' WHERE slug = 'decor' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/plumbing-preview.png', thumbnail = 'themes/previews/plumbing-preview.png' WHERE slug = 'plumbing' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/fitness-preview.png', thumbnail = 'themes/previews/fitness-preview.png' WHERE slug = 'fitness' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/maintenance-preview.png', thumbnail = 'themes/previews/maintenance-preview.png' WHERE slug = 'maintenance' AND preview_image IS NULL;
UPDATE themes SET preview_image = 'themes/previews/legal-preview.png', thumbnail = 'themes/previews/legal-preview.png' WHERE slug = 'legal' AND preview_image IS NULL;
