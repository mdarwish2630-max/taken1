<?php
/**
 * Services List View
 * صفحة قائمة الخدمات
 */

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= lang('services') ?></h3>
        <a href="<?= url('/dashboard/services/add') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i>
            <?= lang('add_service') ?>
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($services)): ?>
        <div class="empty-state">
            <i class="fas fa-concierge-bell" style="font-size: 3rem; color: var(--secondary); margin-bottom: 1rem;"></i>
            <p><?= lang('no_services') ?></p>
            <a href="<?= url('/dashboard/services/add') ?>" class="btn btn-primary mt-3">
                <?= lang('add_service') ?>
            </a>
        </div>
        <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= lang('service_title') ?></th>
                        <th><?= lang('status') ?></th>
                        <th><?= lang('show_on_home') ?></th>
                        <th><?= lang('date') ?></th>
                        <th><?= lang('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $index => $service): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <div class="d-flex align-center gap-2">
                                <?php if ($service->image): ?>
                                <img src="<?= upload($service->image) ?>" alt="<?= $service->title ?>" 
                                     style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                                <?php endif; ?>
                                <div>
                                    <strong><?= $service->title ?></strong>
                                    <?php if ($service->price): ?>
                                    <br><small style="color: var(--accent);"><?= $service->price_text ?: $service->price . ' ر.س' ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if ($service->status === 'active'): ?>
                            <span class="badge badge-success"><?= lang('subscription_active') ?></span>
                            <?php else: ?>
                            <span class="badge badge-secondary"><?= lang('inactive') ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($service->show_on_home): ?>
                            <i class="fas fa-check-circle" style="color: var(--success);"></i>
                            <?php else: ?>
                            <i class="fas fa-times-circle" style="color: var(--secondary);"></i>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($service->created_at)) ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= url('/dashboard/services/edit/' . $service->id) ?>" 
                                   class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-delete="<?= url('/dashboard/services/delete/' . $service->id) ?>"
                                        data-confirm="<?= lang('confirm_delete') ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
