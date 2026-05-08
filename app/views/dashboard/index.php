<?php
/**
 * Dashboard Index View
 * صفحة لوحة التحكم الرئيسية
 */

?>

<div class="stats-grid">
    <!-- Services -->
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-concierge-bell"></i>
        </div>
        <div class="stat-info">
            <h3><?= $stats['services'] ?></h3>
            <p><?= lang('services') ?></p>
        </div>
    </div>
    
    <!-- Gallery -->
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-images"></i>
        </div>
        <div class="stat-info">
            <h3><?= $stats['gallery'] ?></h3>
            <p><?= lang('gallery') ?></p>
        </div>
    </div>
    
    <!-- Testimonials -->
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-comment-dots"></i>
        </div>
        <div class="stat-info">
            <h3><?= $stats['testimonials'] ?></h3>
            <p><?= lang('testimonials') ?></p>
        </div>
    </div>
    
    <!-- Messages -->
    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <h3><?= $stats['messages'] ?></h3>
            <p><?= lang('messages') ?></p>
        </div>
    </div>
</div>

<div class="d-flex gap-3" style="flex-wrap: wrap;">
    <!-- Quick Actions -->
    <div class="card" style="flex: 1; min-width: 300px;">
        <div class="card-header">
            <h3 class="card-title"><?= lang('quick_stats') ?></h3>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2" style="flex-wrap: wrap;">
                <a href="<?= url('/dashboard/services/add') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i>
                    <?= lang('add_service') ?>
                </a>
                <a href="<?= url('/dashboard/gallery') ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-upload"></i>
                    <?= lang('upload_images') ?>
                </a>
                <a href="<?= url('/dashboard/banners') ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-image"></i>
                    <?= lang('add_banner') ?>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Subscription Status -->
    <div class="card" style="flex: 1; min-width: 300px;">
        <div class="card-header">
            <h3 class="card-title"><?= lang('subscription_status') ?></h3>
        </div>
        <div class="card-body">
            <?php if ($tenant->subscription_status === 'trial'): ?>
                <?php 
                $trialEnds = new DateTime($tenant->trial_ends_at);
                $now = new DateTime();
                $daysLeft = $now->diff($trialEnds)->days;
                ?>
                <div class="alert alert-warning">
                    <i class="fas fa-clock"></i>
                    <?= lang('trial_period') ?>: <?= $daysLeft ?> <?= lang('days_left') ?>
                </div>
                <a href="<?= url('/subscription') ?>" class="btn btn-primary btn-sm">
                    <?= lang('renew_subscription') ?>
                </a>
            <?php elseif ($tenant->subscription_status === 'active'): ?>
                <div class="badge badge-success">
                    <i class="fas fa-check-circle"></i>
                    <?= lang('subscription_active') ?>
                </div>
                <p class="mt-2" style="font-size: 0.875rem; color: var(--secondary);">
                    <?= lang('subscription_end') ?>: <?= date('d/m/Y', strtotime($tenant->subscription_end)) ?>
                </p>
            <?php else: ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= lang('subscription_expired') ?>
                </div>
                <a href="<?= url('/subscription') ?>" class="btn btn-primary btn-sm">
                    <?= lang('renew_subscription') ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Recent Messages -->
<?php if (!empty($recent_messages)): ?>
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title"><?= lang('recent_messages') ?></h3>
        <a href="<?= url('/dashboard/messages') ?>" class="btn btn-outline btn-sm">
            <?= lang('view_all') ?>
        </a>
    </div>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th><?= lang('message_name') ?></th>
                    <th><?= lang('message_email') ?></th>
                    <th><?= lang('message_subject') ?></th>
                    <th><?= lang('date') ?></th>
                    <th><?= lang('status') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_messages as $message): ?>
                <tr>
                    <td><?= $this->e($message->name) ?></td>
                    <td><?= $this->e($message->email) ?></td>
                    <td><?= $this->e($message->subject ?: '-') ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($message->created_at)) ?></td>
                    <td>
                        <?php if ($message->is_read): ?>
                            <span class="badge badge-secondary"><?= lang('message_read') ?></span>
                        <?php else: ?>
                            <span class="badge badge-info"><?= lang('message_unread') ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Site Status -->
<?php if ($tenant->site_status === 'draft'): ?>
<div class="card mt-4" style="border-left: 4px solid var(--warning);">
    <div class="card-body">
        <div class="d-flex align-center justify-between" style="gap: 1rem; flex-wrap: wrap;">
            <div>
                <h4><?= lang('preview') ?></h4>
                <p style="color: var(--secondary); font-size: 0.875rem;">
                    موقعك حالياً في وضع المسودة. قم بنشره ليكون متاحاً للزوار.
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= url('/site/' . $tenant->slug) ?>" class="btn btn-outline btn-sm" target="_blank">
                    <i class="fas fa-eye"></i>
                    <?= lang('preview') ?>
                </a>
                <a href="<?= url('/dashboard/publish') ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-globe"></i>
                    <?= lang('publish') ?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
