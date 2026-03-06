<?php
$pageTitle = 'New Listing';
$base = BASE_URL;
require_once ROOT . '/app/views/layouts/header.php';
$err = flash('error');
$sectors = ['Kinigi','Cyuve','Shingiro','Gataraga','Nyange','Remera','Musanze','Muhoza','Muko'];
?>

<div class="app-layout">
  <?php require_once ROOT . '/app/views/layouts/sidebar.php'; ?>
  <main class="main-content">

    <?php if ($err): ?><div class="alert alert-error">⚠️ <?= htmlspecialchars($err) ?></div><?php endif; ?>

    <div class="page-header">
      <div class="page-header-inner">
        <div>
          <h1>＋ New Harvest Listing</h1>
          <p class="page-subtitle">Post your harvest for bulk buyers to find and book.</p>
        </div>
        <a href="<?= $base ?>/index.php?page=listings" class="btn btn-ghost btn-sm">← Back</a>
      </div>
    </div>

    <div class="content-grid">
      <div class="card">
        <div class="card-header"><h3>📋 Listing Details</h3></div>
        <div class="card-body">
          <form method="POST" action="<?= $base ?>/index.php?page=listings&action=store">
            <div class="form-group">
              <label class="form-label">Listing Title <span class="req">*</span></label>
              <input type="text" name="title" class="form-control"
                     placeholder="e.g. Fresh Victoria Potatoes — 500kg Batch"
                     value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Potato Variety <span class="req">*</span></label>
                <select name="variety" class="form-control" required>
                  <option value="">Select variety...</option>
                  <?php foreach(['Victoria','Kinigi White','Gishwati Red','Kirundo','Kachpot-1','Cruza','Other'] as $v): ?>
                    <option value="<?= $v ?>" <?= (($_POST['variety']??'')===$v)?'selected':'' ?>><?= $v ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Pickup Sector <span class="req">*</span></label>
                <select name="pickup_sector" class="form-control" required>
                  <option value="">Select sector...</option>
                  <?php foreach($sectors as $s): ?>
                    <option value="<?= $s ?>" <?= (($_POST['pickup_sector']??'')===$s)?'selected':'' ?>><?= $s ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Quantity (kg) <span class="req">*</span></label>
                <input type="number" name="quantity_kg" id="qty_available" class="form-control"
                       placeholder="e.g. 500" min="1" step="0.5"
                       value="<?= htmlspecialchars($_POST['quantity_kg'] ?? '') ?>" required>
              </div>
              <div class="form-group">
                <label class="form-label">Price per kg (RWF) <span class="req">*</span></label>
                <input type="number" name="price_per_kg" id="listing_price" class="form-control"
                       placeholder="e.g. 280" min="1" step="1"
                       value="<?= htmlspecialchars($_POST['price_per_kg'] ?? '') ?>" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Harvest Date <span class="req">*</span></label>
                <input type="date" name="harvest_date" class="form-control"
                       value="<?= htmlspecialchars($_POST['harvest_date'] ?? date('Y-m-d')) ?>" required>
              </div>
              <div class="form-group">
                <label class="form-label">Listing Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control"
                       value="<?= htmlspecialchars($_POST['expiry_date'] ?? '') ?>">
                <div class="form-hint">Leave blank for no expiry</div>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" placeholder="Quality notes, certifications, special conditions..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px">
              🌾 Submit for Approval
            </button>
            <p style="font-size:.78rem;color:var(--text-lite);text-align:center;margin-top:8px">
              Your listing will be reviewed by admin before going live.
            </p>
          </form>
        </div>
      </div>

      <!-- Listing Value Estimator -->
      <div>
        <div class="card" style="margin-bottom:16px">
          <div class="card-header"><h3>💰 Value Estimator</h3></div>
          <div class="card-body">
            <p style="font-size:.85rem;color:var(--text-mid);margin-bottom:12px">Total listing value based on qty × price:</p>
            <div class="estimator-box">
              <div class="estimator-label">Estimated Listing Value</div>
              <div class="estimator-value" id="listing_total">0 RWF</div>
              <div class="estimator-sub" id="listing_breakdown">Enter quantity and price above</div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header"><h3>📌 Tips for Approval</h3></div>
          <div class="card-body">
            <ul style="padding-left:16px;color:var(--text-mid);font-size:.85rem;line-height:2">
              <li>Set a fair market price (250–350 RWF/kg)</li>
              <li>Add clear variety and pickup details</li>
              <li>Describe any quality certifications</li>
              <li>Ensure harvest date is accurate</li>
              <li>Admin reviews in under 24 hours</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

<script>
// Listing value estimator (different from booking estimator)
const qtyEl   = document.getElementById('qty_available');
const priceEl = document.getElementById('listing_price');
const totEl   = document.getElementById('listing_total');
const brkEl   = document.getElementById('listing_breakdown');

function updateListingEstimate() {
  const qty   = parseFloat(qtyEl?.value) || 0;
  const price = parseFloat(priceEl?.value) || 0;
  const total = qty * price;
  if (totEl) totEl.textContent = total.toLocaleString('en-RW') + ' RWF';
  if (brkEl) brkEl.textContent = qty > 0 && price > 0
    ? `${qty} kg × ${price.toLocaleString()} RWF/kg`
    : 'Enter quantity and price above';
}
qtyEl?.addEventListener('input', updateListingEstimate);
priceEl?.addEventListener('input', updateListingEstimate);
</script>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
