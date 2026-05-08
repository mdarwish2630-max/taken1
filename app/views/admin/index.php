<?php
/**
 * Admin Dashboard View
 * لوحة تحكم المدير
 */

$dir = Language::direction();
?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-tachometer-alt"></i>
        <?= lang('admin_dashboard') ?? 'لوحة تحكم المدير' ?>
    </h1>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card bg-primary">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3><?= $stats['total_users'] ?? 0 ?></h3>
            <p><?= lang('total_users') ?? 'إجمالي المستخدمين' ?></p>
        </div>
    </div>
    
    <div class="stat-card bg-success">
        <div class="stat-icon">
            <i class="fas fa-globe"></i>
        </div>
        <div class="stat-info">
            <h3><?= $stats['total_sites'] ?? 0 ?></h3>
            <p><?= lang('total_sites') ?? 'إجمالي المواقع' ?></p>
        </div>
    </div>
    
    <div class="stat-card bg-info">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3><?= $stats['active_subscriptions'] ?? 0 ?></h3>
            <p><?= lang('active_sites') ?? 'المواقع النشطة' ?></p>
        </div>
    </div>
    
    <div class="stat-card bg-warning">
        <div class="stat-icon">
            <i class="fas fa-palette"></i>
        </div>
        <div class="stat-info">
            <h3><?= $stats['total_themes'] ?? 6 ?></h3>
            <p><?= lang('themes') ?? 'القوالب' ?></p>
        </div>
    </div>
</div>

<!-- Recent Sites -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clock"></i>
            <?= lang('recent_sites') ?? 'آخر المواقع' ?>
        </h3>
        <a href="<?= url('/admin/sites') ?>" class="btn btn-sm btn-outline-primary">
            <?= lang('view_all') ?? 'عرض الكل' ?>
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($recent_sites)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><?= lang('site_name') ?? 'اسم الموقع' ?></th>
                        <th><?= lang('slug') ?? 'الرابط' ?></th>
                        <th><?= lang('owner') ?? 'المالك' ?></th>
                        <th><?= lang('theme') ?? 'القالب' ?></th>
                        <th><?= lang('status') ?? 'الحالة' ?></th>
                        <th><?= lang('created_at') ?? 'تاريخ الإنشاء' ?></th>
                        <th><?= lang('actions') ?? 'الإجراءات' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_sites as $site): ?>
                    <tr>
                        <td><?= $this->e($site->site_name ?? $site['site_name'] ?? '') ?></td>
                        <td>
                            <a href="<?= url('/' . ($site->slug ?? $site['slug'] ?? '')) ?>" target="_blank">
                                <?= $this->e($site->slug ?? $site['slug'] ?? '') ?>
                            </a>
                        </td>
                        <td><?= $this->e($site->owner_name ?? $site['owner_name'] ?? '-') ?></td>
                        <td>
                            <span class="badge badge-info">
                                <?= $this->e($site->theme_name ?? $site['theme_name'] ?? '-') ?>
                            </span>
                        </td>
                        <td>
                            <?php 
                            $status = $site->subscription_status ?? $site['subscription_status'] ?? 'active';
                            $statusClass = $status === 'active' ? 'success' : ($status === 'trial' ? 'info' : ($status === 'expired' ? 'danger' : 'warning'));
                            $statusText = $status === 'active' ? 'نشط' : ($status === 'trial' ? 'تجريبي' : ($status === 'expired' ? 'منتهي' : $status));
                            ?>
                            <span class="badge badge-<?= $statusClass ?>">
                                <?= $statusText ?>
                            </span>
                        </td>
                        <td><?= date('Y-m-d', strtotime($site->created_at ?? $site['created_at'] ?? 'now')) ?></td>
                        <td>
                            <a href="<?= url('/admin/sites/view/' . ($site->id ?? $site['id'])) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-muted text-center py-4"><?= lang('no_sites') ?? 'لا توجد مواقع بعد' ?></p>
        <?php endif; ?>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    border-radius: var(--radius);
    color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.stat-card.bg-primary { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
}

.stat-card.bg-success { 
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); 
}

.stat-card.bg-info { 
    background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); 
}

.stat-card.bg-warning { 
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.9;
    margin-<?= $dir === 'rtl' ? 'left' : 'right' ?>: 1rem;
}

.stat-info h3 {
    font-size: 2rem;
    margin: 0;
    font-weight: bold;
}

.stat-info p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.card {
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
}

.card-title {
    margin: 0;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-body {
    padding: 1.5rem;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 0.75rem 1rem;
    text-align: <?= $dir === 'rtl' ? 'right' : 'left' ?>;
    border-bottom: 1px solid var(--border);
}

.table th {
    font-weight: 600;
    background: var(--bg-secondary);
}

.table tbody tr:hover {
    background: var(--bg-secondary);
}

.badge {
    display: inline-block;
    padding: 0.35rem 0.65rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-success { background: #28a745; color: white; }
.badge-info { background: #17a2b8; color: white; }
.badge-warning { background: #ffc107; color: #212529; }
.badge-danger { background: #dc3545; color: white; }

.btn-sm {
    padding: 0.35rem 0.75rem;
    font-size: 0.85rem;
}

.btn-outline-primary {
    border: 1px solid var(--primary);
    color: var(--primary);
    background: transparent;
    border-radius: 0.25rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

.btn-outline-primary:hover {
    background: var(--primary);
    color: white;
}

.table-responsive {
    overflow-x: auto;
}

.text-muted {
    color: var(--text-muted);
}

.text-center {
    text-align: center;
}

.py-4 {
    padding-top: 2rem;
    padding-bottom: 2rem;
}
</style>
