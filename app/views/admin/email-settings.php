<?php
/**
 * Admin Email Settings View
 * إعدادات البريد الإلكتروني SMTP
 */

$s = $settings ?? [];
$smtpHost = $s['smtp_host'] ?? '';
$smtpPort = $s['smtp_port'] ?? 587;
$smtpUsername = $s['smtp_username'] ?? '';
$smtpPassword = $s['smtp_password'] ?? '';
$smtpEncryption = $s['smtp_encryption'] ?? 'tls';
$smtpFromName = $s['smtp_from_name'] ?? SITE_NAME;
$smtpFromEmail = $s['smtp_from_email'] ?? '';

$isConfigured = !empty($smtpHost) && !empty($smtpUsername);
?>

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-envelope"></i>
        إعدادات البريد الإلكتروني (SMTP)
    </h1>
</div>

<?php if (Session::has('success')): ?>
<div style="background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); border-radius: var(--radius); padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.625rem; color: var(--success); font-size: 0.9rem;">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<?php if (Session::has('error')): ?>
<div style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: var(--radius); padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.625rem; color: var(--danger); font-size: 0.9rem;">
    <i class="fas fa-exclamation-circle"></i>
    <?= Session::getError() ?>
</div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    
    <!-- SMTP Settings Form -->
    <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
        <div style="padding: 1.25rem 1.5rem; background: var(--light); border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-cog" style="color: var(--primary);"></i>
            <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: var(--dark);">إعدادات SMTP</h3>
            <?php if ($isConfigured): ?>
            <span style="margin-right: auto; background: rgba(34,197,94,0.1); color: var(--success); font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; font-weight: 600;">
                <i class="fas fa-check-circle"></i> مُعد
            </span>
            <?php else: ?>
            <span style="margin-right: auto; background: rgba(239,68,68,0.1); color: var(--danger); font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; font-weight: 600;">
                <i class="fas fa-exclamation-circle"></i> غير مُعد
            </span>
            <?php endif; ?>
        </div>

        <form method="POST" action="<?= url('/admin/email-settings') ?>">
            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
            <div style="padding: 1.5rem;">
                
                <!-- SMTP Host -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-server" style="margin-left: 0.375rem; color: var(--primary);"></i>
                        خادم SMTP (Host) <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="smtp_host" value="<?= htmlspecialchars($smtpHost) ?>" placeholder="مثال: smtp.gmail.com" required
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 0.9rem; color: var(--dark); box-sizing: border-box; direction: ltr; text-align: left;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                    <p style="font-size: 0.75rem; color: var(--secondary); margin: 0.375rem 0 0;">عنوان خادم SMTP الخاص بك (مثل: smtp.gmail.com, smtp-relay.sendinblue.com)</p>
                </div>

                <!-- SMTP Port + Encryption -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">
                            <i class="fas fa-hashtag" style="margin-left: 0.375rem; color: var(--primary);"></i>
                            المنفذ (Port)
                        </label>
                        <input type="number" name="smtp_port" value="<?= htmlspecialchars($smtpPort) ?>" placeholder="587"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 0.9rem; color: var(--dark); box-sizing: border-box; direction: ltr; text-align: left;"
                            onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">
                            <i class="fas fa-lock" style="margin-left: 0.375rem; color: var(--primary);"></i>
                            التشفير
                        </label>
                        <select name="smtp_encryption" 
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 0.9rem; color: var(--dark); box-sizing: border-box; background: var(--white); cursor: pointer;">
                            <option value="tls" <?= $smtpEncryption === 'tls' ? 'selected' : '' ?>>TLS (موصى به)</option>
                            <option value="ssl" <?= $smtpEncryption === 'ssl' ? 'selected' : '' ?>>SSL</option>
                            <option value="none" <?= $smtpEncryption === 'none' ? 'selected' : '' ?>>بدون تشفير</option>
                        </select>
                    </div>
                </div>

                <!-- Username -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-user" style="margin-left: 0.375rem; color: var(--primary);"></i>
                        اسم المستخدم (Username) <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="smtp_username" value="<?= htmlspecialchars($smtpUsername) ?>" placeholder="بريدك الإلكتروني أو اسم المستخدم" required
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 0.9rem; color: var(--dark); box-sizing: border-box; direction: ltr; text-align: left;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <!-- Password -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-key" style="margin-left: 0.375rem; color: var(--primary);"></i>
                        كلمة المرور (Password)
                    </label>
                    <div style="position: relative;">
                        <input type="password" name="smtp_password" value="<?= htmlspecialchars($smtpPassword) ?>" placeholder="كلمة مرور SMTP أو App Password" id="smtpPassInput"
                            style="width: 100%; padding: 0.75rem 3rem 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 0.9rem; color: var(--dark); box-sizing: border-box; direction: ltr; text-align: left;"
                            onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        <button type="button" onclick="togglePassword()" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--secondary); cursor: pointer; padding: 4px;">
                            <i class="fas fa-eye" id="togglePassIcon"></i>
                        </button>
                    </div>
                    <p style="font-size: 0.75rem; color: var(--secondary); margin: 0.375rem 0 0;">اتركه فارغاً إذا لم ترد تغيير كلمة المرور الحالية</p>
                </div>

                <!-- Divider -->
                <hr style="border: none; border-top: 1px solid var(--border); margin: 1.5rem 0;">

                <!-- From Name -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-signature" style="margin-left: 0.375rem; color: var(--primary);"></i>
                        اسم المرسل
                    </label>
                    <input type="text" name="smtp_from_name" value="<?= htmlspecialchars($smtpFromName) ?>" placeholder="<?= htmlspecialchars(SITE_NAME) ?>"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 0.9rem; color: var(--dark); box-sizing: border-box;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                    <p style="font-size: 0.75rem; color: var(--secondary); margin: 0.375rem 0 0;">الاسم الذي سيظهر كمُرسل في الإيميلات</p>
                </div>

                <!-- From Email -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-at" style="margin-left: 0.375rem; color: var(--primary);"></i>
                        بريد المرسل
                    </label>
                    <input type="email" name="smtp_from_email" value="<?= htmlspecialchars($smtpFromEmail) ?>" placeholder="noreply@example.com"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 0.9rem; color: var(--dark); box-sizing: border-box; direction: ltr; text-align: left;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <!-- Save Button -->
                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border: none; border-radius: var(--radius); background: var(--primary); color: var(--white); font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: opacity var(--transition);"
                        onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                        <i class="fas fa-save"></i>
                        حفظ الإعدادات
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Sidebar: Test + Info -->
    <div>
        <!-- Test Email -->
        <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 1.5rem;">
            <div style="padding: 1.25rem 1.5rem; background: var(--light); border-bottom: 1px solid var(--border);">
                <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: var(--dark);">
                    <i class="fas fa-paper-plane" style="color: var(--success); margin-left: 0.5rem;"></i>
                    اختبار الإرسال
                </h3>
            </div>
            <div style="padding: 1.25rem;">
                <p style="font-size: 0.85rem; color: var(--secondary); margin-bottom: 1rem;">أرسل إيميل اختباري للتأكد من أن الإعدادات تعمل</p>
                <input type="email" id="testEmail" placeholder="أدخل بريدك الإلكتروني" 
                    style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-family: inherit; font-size: 0.85rem; color: var(--dark); box-sizing: border-box; direction: ltr; text-align: left; margin-bottom: 0.75rem;">
                <button type="button" onclick="sendTestEmail()" id="testBtn" style="width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.625rem; border: none; border-radius: var(--radius); background: var(--success); color: var(--white); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: opacity var(--transition);"
                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <i class="fas fa-paper-plane"></i>
                    إرسال إيميل اختباري
                </button>
                <div id="testResult" style="margin-top: 0.75rem; display: none;"></div>
            </div>
        </div>

        <!-- Common SMTP Providers -->
        <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
            <div style="padding: 1.25rem 1.5rem; background: var(--light); border-bottom: 1px solid var(--border);">
                <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: var(--dark);">
                    <i class="fas fa-info-circle" style="color: var(--primary); margin-left: 0.5rem;"></i>
                    إعدادات شائعة
                </h3>
            </div>
            <div style="padding: 1.25rem;">
                <!-- Gmail -->
                <div onclick="fillSmtp('smtp.gmail.com','587','','','tls')" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid var(--border); border-radius: 8px; margin-bottom: 0.5rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)';this.style.background='var(--light)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--white)'">
                    <i class="fab fa-google" style="color: #ea4335; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--dark);">Gmail</div>
                        <div style="font-size: 0.72rem; color: var(--secondary);">smtp.gmail.com :587 TLS</div>
                    </div>
                </div>
                <!-- Outlook/Office365 -->
                <div onclick="fillSmtp('smtp.office365.com','587','','','tls')" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid var(--border); border-radius: 8px; margin-bottom: 0.5rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)';this.style.background='var(--light)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--white)'">
                    <i class="fab fa-microsoft" style="color: #0078d4; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--dark);">Outlook / Office 365</div>
                        <div style="font-size: 0.72rem; color: var(--secondary);">smtp.office365.com :587 TLS</div>
                    </div>
                </div>
                <!-- SendGrid -->
                <div onclick="fillSmtp('smtp.sendgrid.net','587','apikey','','tls')" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid var(--border); border-radius: 8px; margin-bottom: 0.5rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)';this.style.background='var(--light)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--white)'">
                    <i class="fas fa-paper-plane" style="color: #1a82e2; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--dark);">SendGrid</div>
                        <div style="font-size: 0.72rem; color: var(--secondary);">smtp.sendgrid.net :587 TLS</div>
                    </div>
                </div>
                <!-- Mailgun -->
                <div onclick="fillSmtp('smtp.mailgun.org','587','','','tls')" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)';this.style.background='var(--light)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--white)'">
                    <i class="fas fa-envelope" style="color: #e14e3a; font-size: 1.1rem; width: 24px; text-align: center;"></i>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--dark);">Mailgun</div>
                        <div style="font-size: 0.72rem; color: var(--secondary);">smtp.mailgun.org :587 TLS</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    var input = document.getElementById('smtpPassInput');
    var icon = document.getElementById('togglePassIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

function fillSmtp(host, port, username, password, encryption) {
    document.querySelector('[name="smtp_host"]').value = host;
    document.querySelector('[name="smtp_port"]').value = port;
    if (username) document.querySelector('[name="smtp_username"]').value = username;
    document.querySelector('[name="smtp_encryption"]').value = encryption;
}

function sendTestEmail() {
    var email = document.getElementById('testEmail').value;
    var resultDiv = document.getElementById('testResult');
    var btn = document.getElementById('testBtn');

    if (!email) {
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = '<div style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 8px; padding: 0.75rem; color: var(--danger); font-size: 0.82rem;"><i class="fas fa-exclamation-circle"></i> يرجى إدخال بريد إلكتروني</div>';
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جارٍ الإرسال...';
    resultDiv.style.display = 'block';
    resultDiv.innerHTML = '<div style="background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2); border-radius: 8px; padding: 0.75rem; color: #3b82f6; font-size: 0.82rem;"><i class="fas fa-spinner fa-spin"></i> جارٍ الاتصال بخادم SMTP...</div>';

    var formData = new FormData();
    formData.append('test_email', email);
    formData.append('smtp_host', document.querySelector('[name="smtp_host"]').value);
    formData.append('smtp_port', document.querySelector('[name="smtp_port"]').value);
    formData.append('smtp_username', document.querySelector('[name="smtp_username"]').value);
    formData.append('smtp_password', document.querySelector('[name="smtp_password"]').value);
    formData.append('smtp_encryption', document.querySelector('[name="smtp_encryption"]').value);
    formData.append('smtp_from_name', document.querySelector('[name="smtp_from_name"]').value);
    formData.append('smtp_from_email', document.querySelector('[name="smtp_from_email"]').value);
    formData.append('csrf_token', document.querySelector('[name="csrf_token"]').value);

    fetch('<?= url("/admin/email-settings/test") ?>', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> إرسال إيميل اختباري';
        
        if (data.success) {
            resultDiv.innerHTML = '<div style="background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); border-radius: 8px; padding: 0.75rem; color: var(--success); font-size: 0.82rem;"><i class="fas fa-check-circle"></i> ' + (data.message || 'تم الإرسال بنجاح!') + '</div>';
        } else {
            resultDiv.innerHTML = '<div style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 8px; padding: 0.75rem; color: var(--danger); font-size: 0.82rem;"><i class="fas fa-times-circle"></i> ' + (data.message || 'فشل الإرسال') + '</div>';
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> إرسال إيميل اختباري';
        resultDiv.innerHTML = '<div style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 8px; padding: 0.75rem; color: var(--danger); font-size: 0.82rem;"><i class="fas fa-times-circle"></i> خطأ في الاتصال</div>';
    });
}
</script>
