<?php
$pageTitle = 'Admin Dashboard';
$base = BASE_URL;
require_once ROOT . '/app/views/layouts/header.php';
$msg = flash('success'); $err = flash('error');
$maxSector = !empty($stats['top_sectors']) ? max(array_column($stats['top_sectors'], 'total_listings')) : 1;
?>

<div class="app-layout">
  <?php require_once ROOT . '/app/views/layouts/sidebar.php'; ?>
  <main class="main-content">

    <?php if ($msg): ?><div class="alert alert-success" data-auto-dismiss>✅ <?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert alert-error"   data-auto-dismiss>⚠️ <?= htmlspecialchars($err) ?></div><?php endif; ?>

    <div class="page-header">
      <div class="page-header-inner">
        <div>
          <h1>⚙️ Admin Overview</h1>
          <p class="page-subtitle">AgriStack platform health — <?= date('d F Y') ?></p>
        </div>
        <a href="<?= $base ?>/index.php?page=admin&action=audit" class="btn btn-ghost btn-sm">🔍 View Audit Log</a>
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr))">
      <div class="stat-card amber">
        <div class="stat-icon">📋</div>
        <div class="stat-number" data-target="<?= $stats['today_listings'] ?>"><?= $stats['today_listings'] ?></div>
        <div class="stat-label">Today's Listings</div>
      </div>
      <div class="stat-card earth">
        <div class="stat-icon">⏳</div>
        <div class="stat-number" data-target="<?= $stats['pending_listings'] ?>"><?= $stats['pending_listings'] ?></div>
        <div class="stat-label">Pending Approval</div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon">✅</div>
        <div class="stat-number" data-target="<?= $stats['approved_listings'] ?>"><?= $stats['approved_listings'] ?></div>
        <div class="stat-label">Approved Listings</div>
      </div>
      <div class="stat-card forest">
        <div class="stat-icon">💰</div>
        <div class="stat-number" style="font-size:1.4rem" data-target="<?= $stats['total_booked_value'] ?>" data-float="true">
          <?= number_format($stats['total_booked_value']) ?>
        </div>
        <div class="stat-label">Booked Value (RWF)</div>
      </div>
      <div class="stat-card blue">
        <div class="stat-icon">📦</div>
        <div class="stat-number" data-target="<?= $stats['pending_orders'] ?>"><?= $stats['pending_orders'] ?></div>
        <div class="stat-label">Pending Orders</div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon">🤝</div>
        <div class="stat-number" data-target="<?= $stats['collected_orders'] ?>"><?= $stats['collected_orders'] ?></div>
        <div class="stat-label">Collected Orders</div>
      </div>
      <div class="stat-card amber">
        <div class="stat-icon">🌾</div>
        <div class="stat-number" data-target="<?= $stats['total_farmers'] ?>"><?= $stats['total_farmers'] ?></div>
        <div class="stat-label">Farmers</div>
      </div>
      <div class="stat-card earth">
        <div class="stat-icon">🛒</div>
        <div class="stat-number" data-target="<?= $stats['total_buyers'] ?>"><?= $stats['total_buyers'] ?></div>
        <div class="stat-label">Buyers</div>
      </div>
    </div>

    <div class="content-grid">
      <!-- Top Sectors -->
      <div class="card">
        <div class="card-header">
          <h3>📍 Top Pickup Sectors</h3>
        </div>
        <div class="card-body">
          <?php if (empty($stats['top_sectors'])): ?>
            <p style="color:var(--text-mid)">No data yet.</p>
          <?php else: ?>
            <?php foreach ($stats['top_sectors'] as $s):
              $pct = round(($s['total_listings'] / $maxSector) * 100);
            ?>
            <div class="sector-bar">
              <div class="sector-name">
                <span>📍 <?= htmlspecialchars($s['pickup_sector']) ?></span>
                <span><?= $s['total_listings'] ?> listings · <?= number_format($s['total_kg']) ?> kg</span>
              </div>
              <div class="sector-track"><div class="sector-fill" data-pct="<?= $pct ?>" style="width:0"></div></div>
            </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <!-- Recent Audit -->
      <div class="card">
        <div class="card-header">
          <h3>🔍 Recent Activity</h3>
          <a href="<?= $base ?>/index.php?page=admin&action=audit" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <div class="card-body" style="padding:0">
          <?php if (empty($stats['recent_audit'])): ?>
            <div style="padding:20px;color:var(--text-mid)">No activity yet.</div>
          <?php else: ?>
            <div style="padding:8px 0">
              <?php foreach ($stats['recent_audit'] as $log): ?>
              <div style="padding:10px 18px;border-bottom:1px solid var(--border);font-size:.85rem">
                <div style="font-weight:600"><?= htmlspecialchars($log['action']) ?></div>
                <div style="color:var(--text-mid);font-size:.78rem">
                  by <?= htmlspecialchars($log['user_name'] ?? 'System') ?>
                  · <?= date('d M, H:i', strtotime($log['created_at'])) ?>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card" style="margin-top:24px">
      <div class="card-header"><h3>⚡ Quick Actions</h3></div>
      <div class="card-body" style="display:flex;gap:12px;flex-wrap:wrap">
        <a href="<?= $base ?>/index.php?page=admin&action=listings" class="btn btn-amber">
          📋 Review Listings <?php if($stats['pending_listings']>0): ?><span class="nav-badge"><?= $stats['pending_listings'] ?></span><?php endif; ?>
        </a>
        <a href="<?= $base ?>/index.php?page=admin&action=orders" class="btn btn-primary">
          📦 Approve Orders <?php if($stats['pending_orders']>0): ?><span class="nav-badge"><?= $stats['pending_orders'] ?></span><?php endif; ?>
        </a>
        <a href="<?= $base ?>/index.php?page=admin&action=users" class="btn btn-ghost">👥 Manage Users</a>
        <a href="<?= $base ?>/index.php?page=admin&action=audit" class="btn btn-ghost">🔍 Full Audit Log</a>
      </div>
    </div>

  </main>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
