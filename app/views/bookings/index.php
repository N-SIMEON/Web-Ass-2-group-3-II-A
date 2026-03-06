<?php
$pageTitle = 'My Orders';
$base = BASE_URL;
$role = $_SESSION['user_role'];
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
          <h1>📦 <?= $role==='buyer'?'My Orders':'All Orders' ?></h1>
          <p class="page-subtitle">Track the status of bulk booking requests.</p>
        </div>
        <?php if ($role==='buyer'): ?>
          <a href="<?= $base ?>/index.php?page=listings" class="btn btn-primary">Browse Market →</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="filters-bar">
      <span style="font-size:.8rem;font-weight:600;color:var(--text-mid)">Status:</span>
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="pending">⏳ Pending</button>
      <button class="filter-btn" data-filter="approved">✅ Approved</button>
      <button class="filter-btn" data-filter="collected">📬 Collected</button>
      <button class="filter-btn" data-filter="cancelled">❌ Cancelled</button>
    </div>

    <?php if (empty($bookings)): ?>
      <div class="empty-state">
        <div class="empty-icon">📦</div>
        <h3>No orders yet</h3>
        <p>Browse the marketplace to find and book available harvests.</p>
        <?php if ($role==='buyer'): ?>
          <a href="<?= $base ?>/index.php?page=listings" class="btn btn-primary">Browse Market</a>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <div class="card">
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Listing</th>
                <?php if ($role!=='buyer'): ?><th>Buyer</th><?php endif; ?>
                <th>Farmer</th>
                <th>Qty (kg)</th>
                <th>Total Value</th>
                <th>Pickup Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($bookings as $b): ?>
              <tr data-status="<?= $b['status'] ?>">
                <td style="color:var(--text-lite);font-size:.8rem">#<?= $b['id'] ?></td>
                <td>
                  <strong><?= htmlspecialchars($b['listing_title']) ?></strong><br>
                  <small style="color:var(--text-lite)">🥔 <?= htmlspecialchars($b['variety']) ?> · 📍 <?= htmlspecialchars($b['pickup_sector']) ?></small>
                </td>
                <?php if ($role!=='buyer'): ?>
                  <td><?= htmlspecialchars($b['buyer_name']) ?></td>
                <?php endif; ?>
                <td><?= htmlspecialchars($b['farmer_name']) ?></td>
                <td><?= number_format($b['qty_requested']) ?> kg</td>
                <td><strong><?= number_format($b['total_value']) ?> RWF</strong></td>
                <td><?= $b['pickup_date'] ? date('d M Y', strtotime($b['pickup_date'])) : '—' ?></td>
                <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                <td style="white-space:nowrap">
                  <?php if ($role==='buyer'): ?>
                    <?php if ($b['status']==='approved'): ?>
                      <a href="<?= $base ?>/index.php?page=bookings&action=collect&id=<?= $b['id'] ?>"
                         class="btn btn-success btn-xs" data-confirm="Confirm collection?">✅ Collected</a>
                    <?php elseif ($b['status']==='pending'): ?>
                      <a href="<?= $base ?>/index.php?page=bookings&action=cancel&id=<?= $b['id'] ?>"
                         class="btn btn-danger btn-xs" data-confirm="Cancel this order?">Cancel</a>
                    <?php endif; ?>
                  <?php elseif ($role==='admin'): ?>
                    <?php if ($b['status']==='pending'): ?>
                      <a href="<?= $base ?>/index.php?page=admin&action=approve-order&id=<?= $b['id'] ?>"
                         class="btn btn-success btn-xs" data-confirm="Approve order #<?= $b['id'] ?>?">Approve</a>
                    <?php endif; ?>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

  </main>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
