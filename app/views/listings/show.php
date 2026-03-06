<?php
$pageTitle = htmlspecialchars($listing['title']);
$base = BASE_URL;
$role = $_SESSION['user_role'];
require_once ROOT . '/app/views/layouts/header.php';
?>

<div class="app-layout">
  <?php require_once ROOT . '/app/views/layouts/sidebar.php'; ?>
  <main class="main-content">

    <div class="page-header">
      <div class="page-header-inner">
        <div>
          <h1>🥔 <?= htmlspecialchars($listing['title']) ?></h1>
          <p class="page-subtitle">Listed by <?= htmlspecialchars($listing['farmer_name']) ?></p>
        </div>
        <div style="display:flex;gap:8px">
          <a href="<?= $base ?>/index.php?page=listings" class="btn btn-ghost btn-sm">← Back</a>
          <?php if ($role==='buyer' && $listing['status']==='approved'): ?>
            <a href="<?= $base ?>/index.php?page=bookings&action=create&listing_id=<?= $listing['id'] ?>" class="btn btn-primary">📦 Book Now</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="content-grid">
      <div>
        <div class="card">
          <div class="listing-card-img" style="height:220px;border-radius:0">
            <span style="font-size:6rem">🥔</span>
            <span style="position:absolute;top:16px;right:16px">
              <span class="badge badge-<?= $listing['status'] ?>"><?= ucfirst($listing['status']) ?></span>
            </span>
          </div>
          <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
              <div>
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--text-lite);letter-spacing:.06em">Variety</div>
                <div style="font-weight:600;margin-top:4px"><?= htmlspecialchars($listing['variety']) ?></div>
              </div>
              <div>
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--text-lite);letter-spacing:.06em">Available Quantity</div>
                <div style="font-weight:600;margin-top:4px"><?= number_format($listing['quantity_kg']) ?> kg</div>
              </div>
              <div>
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--text-lite);letter-spacing:.06em">Price per kg</div>
                <div style="font-family:'Fraunces',serif;font-size:1.4rem;font-weight:900;color:var(--forest)"><?= number_format($listing['price_per_kg']) ?> RWF</div>
              </div>
              <div>
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--text-lite);letter-spacing:.06em">Total Value</div>
                <div style="font-weight:600;margin-top:4px"><?= number_format($listing['quantity_kg'] * $listing['price_per_kg']) ?> RWF</div>
              </div>
              <div>
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--text-lite);letter-spacing:.06em">Pickup Sector</div>
                <div style="font-weight:600;margin-top:4px">📍 <?= htmlspecialchars($listing['pickup_sector']) ?></div>
              </div>
              <div>
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--text-lite);letter-spacing:.06em">Harvest Date</div>
                <div style="font-weight:600;margin-top:4px">📅 <?= date('d M Y', strtotime($listing['harvest_date'])) ?></div>
              </div>
            </div>
            <?php if ($listing['description']): ?>
              <div style="padding-top:16px;border-top:1px solid var(--border)">
                <h4 style="margin-bottom:8px">Description</h4>
                <p style="color:var(--text-mid);line-height:1.7"><?= nl2br(htmlspecialchars($listing['description'])) ?></p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div>
        <div class="card">
          <div class="card-header"><h3>👤 Farmer Info</h3></div>
          <div class="card-body">
            <div style="font-size:1.1rem;font-weight:700"><?= htmlspecialchars($listing['farmer_name']) ?></div>
            <?php if ($listing['coop_name']): ?>
              <div style="color:var(--text-mid);font-size:.875rem;margin-top:4px">🤝 <?= htmlspecialchars($listing['coop_name']) ?></div>
            <?php endif; ?>
            <?php if ($role==='buyer' || $role==='admin'): ?>
              <div style="color:var(--text-mid);font-size:.875rem;margin-top:4px">📞 <?= htmlspecialchars($listing['farmer_phone']) ?></div>
            <?php endif; ?>
            <div style="color:var(--text-mid);font-size:.875rem;margin-top:4px">📍 <?= htmlspecialchars($listing['farmer_sector']) ?></div>
          </div>
        </div>

        <?php if ($role==='buyer' && $listing['status']==='approved'): ?>
        <div class="card" style="margin-top:16px">
          <div class="card-header"><h3>📦 Ready to Book?</h3></div>
          <div class="card-body">
            <p style="color:var(--text-mid);font-size:.875rem;margin-bottom:16px">
              Place a bulk booking request for this harvest.
            </p>
            <a href="<?= $base ?>/index.php?page=bookings&action=create&listing_id=<?= $listing['id'] ?>"
               class="btn btn-primary" style="width:100%;justify-content:center">
              Book This Harvest →
            </a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>

  </main>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
