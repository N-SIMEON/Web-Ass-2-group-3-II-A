<?php
$pageTitle = 'Book Harvest';
$base = BASE_URL;
require_once ROOT . '/app/views/layouts/header.php';
$err = flash('error');
?>

<div class="app-layout">
  <?php require_once ROOT . '/app/views/layouts/sidebar.php'; ?>
  <main class="main-content">

    <?php if ($err): ?><div class="alert alert-error">⚠️ <?= htmlspecialchars($err) ?></div><?php endif; ?>

    <div class="page-header">
      <div class="page-header-inner">
        <div>
          <h1>📦 Place Bulk Order</h1>
          <p class="page-subtitle">Request a bulk booking for this harvest listing.</p>
        </div>
        <a href="<?= $base ?>/index.php?page=listings" class="btn btn-ghost btn-sm">← Back to Market</a>
      </div>
    </div>

    <div class="content-grid">
      <!-- Form -->
      <div class="card">
        <div class="card-header">
          <h3>📋 Booking Details</h3>
          <span class="badge badge-approved">Available Now</span>
        </div>
        <div class="card-body">
          <!-- Listing summary -->
          <div style="background:var(--mist);border-radius:10px;padding:16px;margin-bottom:24px;border:1px solid var(--border)">
            <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--text-lite);margin-bottom:8px">Booking for</div>
            <h4><?= htmlspecialchars($listing['title']) ?></h4>
            <div style="display:flex;gap:16px;margin-top:8px;flex-wrap:wrap">
              <span style="font-size:.85rem;color:var(--text-mid)">🥔 <?= htmlspecialchars($listing['variety']) ?></span>
              <span style="font-size:.85rem;color:var(--text-mid)">⚖️ Max <?= number_format($listing['quantity_kg']) ?> kg</span>
              <span style="font-size:.85rem;color:var(--forest);font-weight:700"><?= number_format($listing['price_per_kg']) ?> RWF/kg</span>
              <span style="font-size:.85rem;color:var(--text-mid)">📍 <?= htmlspecialchars($listing['pickup_sector']) ?></span>
            </div>
          </div>

          <form method="POST" action="<?= $base ?>/index.php?page=bookings&action=store">
            <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
            <input type="hidden" id="price_per_kg_hidden" value="<?= $listing['price_per_kg'] ?>">
            <input type="hidden" id="max_qty" value="<?= $listing['quantity_kg'] ?>">

            <div class="form-group">
              <label class="form-label">Quantity to Book (kg) <span class="req">*</span></label>
              <input type="number" name="qty_requested" id="qty_requested" class="form-control"
                     placeholder="e.g. 200" min="1" max="<?= $listing['quantity_kg'] ?>" step="0.5" required autofocus>
              <div class="form-hint">Maximum available: <?= number_format($listing['quantity_kg']) ?> kg</div>
              <div id="qty_warn" style="display:none;color:var(--danger);font-size:.82rem;margin-top:4px">
                ⚠️ Exceeds available quantity!
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Delivery / Pickup Address <span class="req">*</span></label>
              <input type="text" name="delivery_address" class="form-control"
                     placeholder="e.g. Kigali Central Market, KN 5 Road"
                     value="<?= htmlspecialchars($_POST['delivery_address'] ?? '') ?>" required>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Preferred Pickup Date</label>
                <input type="date" name="pickup_date" class="form-control"
                       min="<?= date('Y-m-d') ?>"
                       value="<?= htmlspecialchars($_POST['pickup_date'] ?? '') ?>">
              </div>
              <div class="form-group"></div>
            </div>

            <div class="form-group">
              <label class="form-label">Special Notes</label>
              <textarea name="notes" class="form-control" placeholder="Delivery time preference, quality requirements..."><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
            </div>

            <!-- Live Estimator -->
            <div class="estimator-box" style="margin-bottom:20px">
              <div class="estimator-label">Order Total</div>
              <div class="estimator-value" id="total_estimate">0 RWF</div>
              <div class="estimator-sub" id="estimate_breakdown">Enter quantity above to see total</div>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px">
              📦 Submit Booking Request
            </button>
            <p style="font-size:.78rem;color:var(--text-lite);text-align:center;margin-top:8px">
              Your booking will be reviewed and approved by admin.
            </p>
          </form>
        </div>
      </div>

      <!-- Info Panel -->
      <div>
        <div class="card">
          <div class="card-header"><h3>🔄 Booking Workflow</h3></div>
          <div class="card-body">
            <div class="status-trail" style="flex-direction:column;gap:0">
              <?php
              $steps = [
                ['Pending',   '📝', 'You submit booking request'],
                ['Approved',  '✅', 'Admin reviews and approves'],
                ['Collected', '🤝', 'You collect the harvest'],
              ];
              foreach ($steps as $i => [$label, $icon, $desc]):
              ?>
              <div style="display:flex;gap:14px;align-items:flex-start;padding:12px 0;<?= $i<count($steps)-1?'border-bottom:1px dashed var(--border)':'' ?>">
                <div style="width:36px;height:36px;border-radius:50%;background:var(--parchment);border:2px solid var(--border);display:grid;place-items:center;flex-shrink:0;font-size:1rem"><?= $icon ?></div>
                <div>
                  <div style="font-weight:600;font-size:.9rem"><?= $label ?></div>
                  <div style="color:var(--text-mid);font-size:.8rem"><?= $desc ?></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <div class="card" style="margin-top:16px">
          <div class="card-header"><h3>👤 Farmer Contact</h3></div>
          <div class="card-body">
            <div style="font-weight:600"><?= htmlspecialchars($listing['farmer_name']) ?></div>
            <?php if ($listing['coop_name']): ?>
              <div style="color:var(--text-mid);font-size:.875rem">🤝 <?= htmlspecialchars($listing['coop_name']) ?></div>
            <?php endif; ?>
            <div style="color:var(--text-mid);font-size:.875rem;margin-top:4px">📞 <?= htmlspecialchars($listing['farmer_phone']) ?></div>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
