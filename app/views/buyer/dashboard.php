<?php
$pageTitle = 'Buyer Dashboard';
$base = BASE_URL;
require_once ROOT . '/app/views/layouts/header.php';
$msg = flash('success'); $err = flash('error');
?>

<div class="app-layout">
  <?php require_once ROOT . '/app/views/layouts/sidebar.php'; ?>
  <main class="main-content">

    <?php if ($msg): ?><div class="alert alert-success" data-auto-dismiss>✅ <?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert alert-error"   data-auto-dismiss>⚠️ <?= htmlspecialchars($err) ?></div><?php endif; ?>

    <div class="page-header">
      <div class="page-header-inner">
        <div>
          <h1>🛒 Hello, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]) ?>!</h1>
          <p class="page-subtitle">Browse available harvests and manage your bulk orders.</p>
        </div>
        <a href="<?= $base ?>/index.php?page=listings" class="btn btn-primary">Browse Market →</a>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card green">
        <div class="stat-icon">📦</div>
        <div class="stat-number" data-target="<?= $stats['total_bookings'] ?>"><?= $stats['total_bookings'] ?></div>
        <div class="stat-label">Total Orders</div>
      </div>
      <div class="stat-card amber">
        <div class="stat-icon">⏳</div>
        <div class="stat-number" data-target="<?= $stats['pending'] ?>"><?= $stats['pending'] ?></div>
        <div class="stat-label">Awaiting Approval</div>
      </div>
      <div class="stat-card forest">
        <div class="stat-icon">✅</div>
        <div class="stat-number" data-target="<?= $stats['approved'] ?>"><?= $stats['approved'] ?></div>
        <div class="stat-label">Approved</div>
      </div>
      <div class="stat-card blue">
        <div class="stat-icon">💰</div>
        <div class="stat-number" data-target="<?= $stats['total_spent'] ?>" data-float="true">
          <?= number_format($stats['total_spent']) ?>
        </div>
        <div class="stat-label">Total Value (RWF)</div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3>My Orders</h3>
        <a href="<?= $base ?>/index.php?page=bookings" class="btn btn-ghost btn-sm">View All</a>
      </div>
      <div class="card-body" style="padding:0">
        <?php if (empty($bookings)): ?>
          <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3>No orders yet</h3>
            <p>Browse the market and place your first bulk order.</p>
            <a href="<?= $base ?>/index.php?page=listings" class="btn btn-primary">Browse Listings</a>
          </div>
        <?php else: ?>
          <div class="table-wrap">
            <table>
              <thead>
                <tr><th>Listing</th><th>Variety</th><th>Qty</th><th>Total Value</th><th>Pickup</th><th>Status</th><th>Actions</th></tr>
              </thead>
              <tbody>
                <?php foreach (array_slice($bookings,0,8) as $b): ?>
                <tr data-status="<?= $b['status'] ?>">
                  <td><strong><?= htmlspecialchars($b['listing_title']) ?></strong></td>
                  <td><?= htmlspecialchars($b['variety']) ?></td>
                  <td><?= number_format($b['qty_requested']) ?> kg</td>
                  <td><strong><?= number_format($b['total_value']) ?> RWF</strong></td>
                  <td><?= htmlspecialchars($b['pickup_sector']) ?></td>
                  <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                  <td>
                    <?php if ($b['status']==='approved'): ?>
                      <a href="<?= $base ?>/index.php?page=bookings&action=collect&id=<?= $b['id'] ?>"
                         class="btn btn-success btn-xs" data-confirm="Mark as collected?">Collected</a>
                    <?php elseif ($b['status']==='pending'): ?>
                      <a href="<?= $base ?>/index.php?page=bookings&action=cancel&id=<?= $b['id'] ?>"
                         class="btn btn-danger btn-xs" data-confirm="Cancel this order?">Cancel</a>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </main>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
