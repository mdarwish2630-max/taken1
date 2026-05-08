<?php
/**
 * Admin - Analytics
 * الإحصائيات
 */

$dir = Language::direction();
?>

<div class="page-header">
    <h1 class="page-title"><?= lang('analytics') ?? 'الإحصائيات' ?></h1>
</div>

<!-- Monthly Stats -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title"><?= lang('monthly_registrations') ?? 'التسجيلات الشهرية' ?></h3>
    </div>
    <div class="card-body">
        <?php if (!empty($monthly_stats)): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= lang('month') ?? 'الشهر' ?></th>
                        <th><?= lang('new_sites') ?? 'مواقع جديدة' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($monthly_stats as $stat): ?>
                    <tr>
                        <td><?= $this->e($stat->month) ?></td>
                        <td><strong><?= $stat->total ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-muted text-center py-4"><?= lang('no_data') ?? 'لا توجد بيانات' ?></p>
        <?php endif; ?>
    </div>
</div>

<!-- Theme Distribution -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= lang('theme_distribution') ?? 'توزيع القوالب' ?></h3>
    </div>
    <div class="card-body">
        <?php if (!empty($theme_distribution)): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= lang('theme') ?? 'القالب' ?></th>
                        <th><?= lang('count') ?? 'العدد' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($theme_distribution as $theme): ?>
                    <tr>
                        <td><?= $this->e($theme->name) ?></td>
                        <td><strong><?= $theme->count ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-muted text-center py-4"><?= lang('no_data') ?? 'لا توجد بيانات' ?></p>
        <?php endif; ?>
    </div>
</div>
