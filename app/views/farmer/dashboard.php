<?php
$pageTitle = 'Farmer Dashboard';
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
          <h1>🌾 Good morning, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]) ?>!</h1>
          <p class="page-subtitle">Manage your harvest listings and track your sales.</p>
        </div>
        <a href="<?= $base ?>/index.php?page=listings&action=create" class="btn btn-primary">＋ New Listing</a>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card green">
        <div class="stat-icon">📋</div>
        <div class="stat-number" data-target="<?= $stats['total_listings'] ?>"><?= $stats['total_listings'] ?></div>
        <div class="stat-label">Total Listings</div>
      </div>
      <div class="stat-card amber">
        <div class="stat-icon">⏳</div>
        <div class="stat-number" data-target="<?= $stats['pending'] ?>"><?= $stats['pending'] ?></div>
        <div class="stat-label">Pending Approval</div>
      </div>
      <div class="stat-card forest">
        <div class="stat-icon">✅</div>
        <div class="stat-number" data-target="<?= $stats['approved'] ?>"><?= $stats['approved'] ?></div>
        <div class="stat-label">Approved & Live</div>
      </div>
      <div class="stat-card earth">
        <div class="stat-icon">❌</div>
        <div class="stat-number" data-target="<?= $stats['rejected'] ?>"><?= $stats['rejected'] ?></div>
        <div class="stat-label">Rejected</div>
      </div>
    </div>

    <!-- Recent listings table -->
    <div class="card">
      <div class="card-header">
        <h3>Recent Listings</h3>
        <a href="<?= $base ?>/index.php?page=listings" class="btn btn-ghost btn-sm">View All</a>
      </div>
      <div class="card-body" style="padding:0">
        <?php if (empty($listings)): ?>
          <div class="empty-state">
            <div class="empty-icon">🌱</div>
            <h3>No listings yet</h3>
            <p>Post your first harvest to connect with bulk buyers.</p>
            <a href="<?= $base ?>/index.php?page=listings&action=create" class="btn btn-primary">Post a Listing</a>
          </div>
        <?php else: ?>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Listing</th>
                  <th>Variety</th>
                  <th>Qty (kg)</th>
                  <th>Price/kg</th>
                  <th>Harvest Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (array_slice($listings, 0, 8) as $l): ?>
                <tr data-status="<?= $l['status'] ?>">
                  <td><strong><?= htmlspecialchars($l['title']) ?></strong><br><small style="color:var(--text-lite)"><?= htmlspecialchars($l['pickup_sector']) ?></small></td>
                  <td><?= htmlspecialchars($l['variety']) ?></td>
                  <td><?= number_format($l['quantity_kg']) ?></td>
                  <td><?= number_format($l['price_per_kg']) ?> RWF</td>
                  <td><?= date('d M Y', strtotime($l['harvest_date'])) ?></td>
                  <td><span class="badge badge-<?= $l['status'] ?>"><?= ucfirst($l['status']) ?></span></td>
                  <td>
                    <?php if ($l['status'] !== 'approved'): ?>
                      <a href="<?= $base ?>/index.php?page=listings&action=edit&id=<?= $l['id'] ?>" class="btn btn-ghost btn-xs">Edit</a>
                      <a href="<?= $base ?>/index.php?page=listings&action=delete&id=<?= $l['id'] ?>"
                         class="btn btn-danger btn-xs"
                         data-confirm="Delete this listing?">Del</a>
                    <?php else: ?>
                      <span style="font-size:.75rem;color:var(--text-lite)">Live</span>
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
