<?php
/**
 * Analytics View
 * صفحة الإحصائيات
 */


$tenant = $tenant ?? Auth::tenant();
$lang = Language::current();
?>

<div class="page-header d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-0">
        <i class="fas fa-chart-line me-2"></i>
        <?= lang('analytics') ?>
    </h1>
    <div class="d-flex gap-2">
        <select class="form-select form-select-sm" id="dateRange" onchange="updateAnalytics()">
            <option value="7"><?= lang('last_7_days') ?></option>
            <option value="30" selected><?= lang('last_30_days') ?></option>
            <option value="90"><?= lang('last_90_days') ?></option>
        </select>
        <button class="btn btn-outline-primary btn-sm" onclick="exportReport()">
            <i class="fas fa-download me-1"></i>
            <?= lang('export') ?>
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0 opacity-75"><?= lang('page_views') ?></h6>
                        <h2 class="mb-0" id="totalViews">-</h2>
                    </div>
                    <i class="fas fa-eye fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0 opacity-75"><?= lang('unique_visitors') ?></h6>
                        <h2 class="mb-0" id="uniqueVisitors">-</h2>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0 opacity-75"><?= lang('avg_time') ?></h6>
                        <h2 class="mb-0" id="avgTime">-</h2>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0 opacity-75"><?= lang('bounce_rate') ?></h6>
                        <h2 class="mb-0" id="bounceRate">-</h2>
                    </div>
                    <i class="fas fa-sign-out-alt fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Views Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-area me-2"></i>
                    <?= lang('page_views') ?>
                </h5>
            </div>
            <div class="card-body">
                <canvas id="viewsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Traffic Sources -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-share-alt me-2"></i>
                    <?= lang('traffic_sources') ?>
                </h5>
            </div>
            <div class="card-body">
                <canvas id="sourcesChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Pages -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-alt me-2"></i>
                    <?= lang('top_pages') ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th><?= lang('page') ?></th>
                                <th width="100"><?= lang('views') ?></th>
                            </tr>
                        </thead>
                        <tbody id="topPagesTable">
                            <tr>
                                <td colspan="2" class="text-center py-3">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Device Types -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-mobile-alt me-2"></i>
                    <?= lang('device_types') ?>
                </h5>
            </div>
            <div class="card-body">
                <canvas id="devicesChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Countries -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-globe me-2"></i>
                    <?= lang('countries') ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th><?= lang('country') ?></th>
                                <th width="100"><?= lang('visitors') ?></th>
                            </tr>
                        </thead>
                        <tbody id="countriesTable">
                            <tr>
                                <td colspan="2" class="text-center py-3">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Browsers -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-browser me-2"></i>
                    <?= lang('browsers') ?>
                </h5>
            </div>
            <div class="card-body">
                <canvas id="browsersChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let viewsChart, sourcesChart, devicesChart, browsersChart;

// Load analytics data
function updateAnalytics() {
    const days = document.getElementById('dateRange').value;
    
    fetch(`<?= url('/dashboard/analytics/details') ?>?days=${days}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStats(data.data);
                updateCharts(data.data);
                updateTables(data.data);
            }
        });
}

function updateStats(data) {
    document.getElementById('totalViews').textContent = formatNumber(data.total_views || 0);
    document.getElementById('uniqueVisitors').textContent = formatNumber(data.unique_visitors || 0);
    document.getElementById('avgTime').textContent = data.avg_time || '0:00';
    document.getElementById('bounceRate').textContent = (data.bounce_rate || 0) + '%';
}

function updateCharts(data) {
    // Views Chart
    const viewsCtx = document.getElementById('viewsChart').getContext('2d');
    if (viewsChart) viewsChart.destroy();
    
    viewsChart = new Chart(viewsCtx, {
        type: 'line',
        data: {
            labels: data.chart_labels || [],
            datasets: [{
                label: '<?= lang('page_views') ?>',
                data: data.chart_data || [],
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
    
    // Sources Chart
    const sourcesCtx = document.getElementById('sourcesChart').getContext('2d');
    if (sourcesChart) sourcesChart.destroy();
    
    sourcesChart = new Chart(sourcesCtx, {
        type: 'doughnut',
        data: {
            labels: ['<?= lang('direct') ?>', '<?= lang('organic') ?>', '<?= lang('social') ?>', '<?= lang('referral') ?>'],
            datasets: [{
                data: data.sources || [0, 0, 0, 0],
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    
    // Devices Chart
    const devicesCtx = document.getElementById('devicesChart').getContext('2d');
    if (devicesChart) devicesChart.destroy();
    
    devicesChart = new Chart(devicesCtx, {
        type: 'bar',
        data: {
            labels: ['Desktop', 'Mobile', 'Tablet'],
            datasets: [{
                data: data.devices || [0, 0, 0],
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
    
    // Browsers Chart
    const browsersCtx = document.getElementById('browsersChart').getContext('2d');
    if (browsersChart) browsersChart.destroy();
    
    browsersChart = new Chart(browsersCtx, {
        type: 'pie',
        data: {
            labels: data.browser_labels || ['Chrome', 'Safari', 'Firefox', 'Edge'],
            datasets: [{
                data: data.browsers || [0, 0, 0, 0],
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function updateTables(data) {
    // Top Pages
    const topPagesHtml = (data.top_pages || []).map(page => `
        <tr>
            <td>${page.url}</td>
            <td><strong>${formatNumber(page.views)}</strong></td>
        </tr>
    `).join('') || '<tr><td colspan="2" class="text-center text-muted">لا توجد بيانات</td></tr>';
    document.getElementById('topPagesTable').innerHTML = topPagesHtml;
    
    // Countries
    const countriesHtml = (data.countries || []).map(country => `
        <tr>
            <td><i class="fas fa-globe text-muted me-2"></i>${country.name}</td>
            <td><strong>${formatNumber(country.visitors)}</strong></td>
        </tr>
    `).join('') || '<tr><td colspan="2" class="text-center text-muted">لا توجد بيانات</td></tr>';
    document.getElementById('countriesTable').innerHTML = countriesHtml;
}

function formatNumber(num) {
    return new Intl.NumberFormat('<?= $lang === 'ar' ? 'ar-SA' : 'en-US' ?>').format(num);
}

function exportReport() {
    window.location.href = '<?= url('/dashboard/analytics/export') ?>?days=' + document.getElementById('dateRange').value;
}

// Initial load
updateAnalytics();
</script>
