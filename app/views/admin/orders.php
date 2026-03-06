<?php
$pageTitle = 'Manage Orders';
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
          <h1>📦 Manage Orders</h1>
          <p class="page-subtitle">Review and approve bulk booking requests.</p>
        </div>
        <a href="<?= $base ?>/index.php?page=admin" class="btn btn-ghost btn-sm">← Dashboard</a>
      </div>
    </div>

    <div class="filters-bar">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="pending">⏳ Pending</button>
      <button class="filter-btn" data-filter="approved">✅ Approved</button>
      <button class="filter-btn" data-filter="collected">📬 Collected</button>
      <button class="filter-btn" data-filter="cancelled">❌ Cancelled</button>
    </div>

    <div class="card">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Listing</th>
              <th>Buyer</th>
              <th>Farmer</th>
              <th>Qty (kg)</th>
              <th>Total (RWF)</th>
              <th>Pickup</th>
              <th>Requested</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($bookings)): ?>
              <tr><td colspan="10" style="text-align:center;padding:40px;color:var(--text-mid)">No orders yet.</td></tr>
            <?php else: ?>
              <?php foreach ($bookings as $b): ?>
              <tr data-status="<?= $b['status'] ?>">
                <td style="color:var(--text-lite);font-size:.8rem">#<?= $b['id'] ?></td>
                <td>
                  <strong><?= htmlspecialchars($b['listing_title']) ?></strong><br>
                  <small style="color:var(--text-lite)">📍 <?= htmlspecialchars($b['pickup_sector']) ?></small>
                </td>
                <td><?= htmlspecialchars($b['buyer_name']) ?></td>
                <td><?= htmlspecialchars($b['farmer_name']) ?></td>
                <td><?= number_format($b['qty_requested']) ?></td>
                <td><strong><?= number_format($b['total_value']) ?></strong></td>
                <td><?= $b['pickup_date'] ? date('d M', strtotime($b['pickup_date'])) : '—' ?></td>
                <td><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                <td>
                  <?php if ($b['status']==='pending'): ?>
                    <a href="<?= $base ?>/index.php?page=admin&action=approve-order&id=<?= $b['id'] ?>"
                       class="btn btn-success btn-xs" data-confirm="Approve order #<?= $b['id'] ?>?">✅ Approve</a>
                  <?php else: ?>
                    <span style="font-size:.75rem;color:var(--text-lite)">—</span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
