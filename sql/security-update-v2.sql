-- ============================================
-- التحديثات الأمنية v2 - تكوين منصة CMS
-- 1. تأكيد البريد الإلكتروني الإجباري
-- 2. إضافة عمود remember_token (لو مش موجود)
-- ============================================

-- التأكد من وجود عمود remember_token
ALTER TABLE users ADD COLUMN IF NOT EXISTS remember_token VARCHAR(255) DEFAULT NULL;

-- تحديث المستخدمين الحاليين (اختياري - تفعيل بريد المدير)
-- UPDATE users SET email_verified = 1 WHERE role = 'admin' AND email_verified = 0;

-- ملاحظة: لا حاجة لتعديل الجداول للكابتشا لأنها تعتمد على الجلسة (Session) فقط
