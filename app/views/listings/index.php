<?php
$pageTitle = 'Listings';
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
          <h1><?= $role==='farmer' ? '🌾 My Listings' : '🛒 Marketplace' ?></h1>
          <p class="page-subtitle">
            <?= $role==='farmer' ? 'All your harvest listings' : 'Browse approved harvest listings from Musanze cooperatives' ?>
          </p>
        </div>
        <?php if ($role==='farmer'): ?>
          <a href="<?= $base ?>/index.php?page=listings&action=create" class="btn btn-primary">＋ New Listing</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Filters -->
    <div class="filters-bar">
      <span style="font-size:.8rem;font-weight:600;color:var(--text-mid)">Filter:</span>
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="pending">⏳ Pending</button>
      <button class="filter-btn" data-filter="approved">✅ Approved</button>
      <?php if ($role==='farmer'): ?>
        <button class="filter-btn" data-filter="rejected">❌ Rejected</button>
      <?php endif; ?>
      <span style="margin-left:auto;font-size:.82rem;color:var(--text-mid)"><?= count($listings) ?> listings found</span>
    </div>

    <?php if (empty($listings)): ?>
      <div class="empty-state">
        <div class="empty-icon">🌱</div>
        <h3>No listings <?= $role==='farmer'?'yet':'available' ?></h3>
        <?php if ($role==='farmer'): ?>
          <p>Post your first harvest listing to connect with buyers.</p>
          <a href="<?= $base ?>/index.php?page=listings&action=create" class="btn btn-primary">Post a Listing</a>
        <?php else: ?>
          <p>Check back soon — farmers are adding new harvests daily.</p>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <div class="listing-grid">
        <?php foreach ($listings as $l): ?>
        <div class="listing-card" data-status="<?= $l['status'] ?>">
          <div class="listing-card-img">
            🥔
            <span style="position:absolute;top:12px;right:12px">
              <span class="badge badge-<?= $l['status'] ?>"><?= ucfirst($l['status']) ?></span>
            </span>
          </div>
          <div class="listing-card-body">
            <h4 style="margin-bottom:4px"><?= htmlspecialchars($l['title']) ?></h4>
            <div class="listing-price"><?= number_format($l['price_per_kg']) ?> <span>RWF/kg</span></div>
            <div class="listing-meta">
              <span class="listing-meta-item">🥔 <?= htmlspecialchars($l['variety']) ?></span>
              <span class="listing-meta-item">⚖️ <?= number_format($l['quantity_kg']) ?> kg</span>
              <span class="listing-meta-item">📍 <?= htmlspecialchars($l['pickup_sector']) ?></span>
              <span class="listing-meta-item">📅 <?= date('d M Y', strtotime($l['harvest_date'])) ?></span>
            </div>
            <?php if ($l['coop_name']): ?>
              <div style="margin-top:8px;font-size:.78rem;color:var(--text-mid)">
                🤝 <?= htmlspecialchars($l['coop_name']) ?>
              </div>
            <?php endif; ?>
            <div style="display:flex;gap:8px;margin-top:14px">
              <a href="<?= $base ?>/index.php?page=listings&action=show&id=<?= $l['id'] ?>" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center">View</a>
              <?php if ($role==='buyer' && $l['status']==='approved'): ?>
                <a href="<?= $base ?>/index.php?page=bookings&action=create&listing_id=<?= $l['id'] ?>" class="btn btn-primary btn-sm" style="flex:1;justify-content:center">Book Now</a>
              <?php elseif ($role==='farmer'): ?>
                <?php if ($l['status'] !== 'approved'): ?>
                  <a href="<?= $base ?>/index.php?page=listings&action=edit&id=<?= $l['id'] ?>" class="btn btn-ghost btn-sm">Edit</a>
                  <a href="<?= $base ?>/index.php?page=listings&action=delete&id=<?= $l['id'] ?>"
                     class="btn btn-danger btn-sm" data-confirm="Delete this listing permanently?">Del</a>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </main>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
