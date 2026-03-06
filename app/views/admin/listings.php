<?php
$pageTitle = 'Manage Listings';
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
          <h1>📋 Manage Listings</h1>
          <p class="page-subtitle">Approve or reject harvest listings from farmers.</p>
        </div>
        <a href="<?= $base ?>/index.php?page=admin" class="btn btn-ghost btn-sm">← Dashboard</a>
      </div>
    </div>

    <div class="filters-bar">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="pending">⏳ Pending</button>
      <button class="filter-btn" data-filter="approved">✅ Approved</button>
      <button class="filter-btn" data-filter="rejected">❌ Rejected</button>
      <span style="margin-left:auto;font-size:.82rem;color:var(--text-mid)"><?= count($listings) ?> total</span>
    </div>

    <div class="card">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Listing</th>
              <th>Farmer / Coop</th>
              <th>Variety</th>
              <th>Qty (kg)</th>
              <th>Price/kg</th>
              <th>Sector</th>
              <th>Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($listings)): ?>
              <tr><td colspan="9" style="text-align:center;padding:40px;color:var(--text-mid)">No listings found.</td></tr>
            <?php else: ?>
              <?php foreach ($listings as $l): ?>
              <tr data-status="<?= $l['status'] ?>">
                <td>
                  <strong><?= htmlspecialchars($l['title']) ?></strong>
                  <?php if ($l['description']): ?>
                    <div style="font-size:.75rem;color:var(--text-lite);max-width:200px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis">
                      <?= htmlspecialchars($l['description']) ?>
                    </div>
                  <?php endif; ?>
                </td>
                <td>
                  <?= htmlspecialchars($l['farmer_name']) ?>
                  <?php if ($l['coop_name']): ?>
                    <div style="font-size:.75rem;color:var(--text-lite)"><?= htmlspecialchars($l['coop_name']) ?></div>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($l['variety']) ?></td>
                <td><?= number_format($l['quantity_kg']) ?></td>
                <td><?= number_format($l['price_per_kg']) ?> RWF</td>
                <td>📍 <?= htmlspecialchars($l['pickup_sector']) ?></td>
                <td><?= date('d M', strtotime($l['harvest_date'])) ?></td>
                <td><span class="badge badge-<?= $l['status'] ?>"><?= ucfirst($l['status']) ?></span></td>
                <td style="white-space:nowrap">
                  <?php if ($l['status']==='pending'): ?>
                    <a href="<?= $base ?>/index.php?page=admin&action=approve&id=<?= $l['id'] ?>"
                       class="btn btn-success btn-xs" data-confirm="Approve this listing?">✅ Approve</a>
                    <a href="<?= $base ?>/index.php?page=admin&action=reject&id=<?= $l['id'] ?>"
                       class="btn btn-danger btn-xs" data-confirm="Reject this listing?">❌ Reject</a>
                  <?php elseif ($l['status']==='approved'): ?>
                    <span style="font-size:.75rem;color:var(--success);font-weight:600">✅ Live</span>
                  <?php else: ?>
                    <a href="<?= $base ?>/index.php?page=admin&action=approve&id=<?= $l['id'] ?>"
                       class="btn btn-ghost btn-xs" data-confirm="Re-approve this listing?">Re-approve</a>
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
