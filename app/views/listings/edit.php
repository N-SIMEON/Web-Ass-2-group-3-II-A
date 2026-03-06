<?php
$pageTitle = 'Edit Listing';
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
          <h1>✏️ Edit Listing</h1>
          <p class="page-subtitle">Update your harvest listing details.</p>
        </div>
        <a href="<?= $base ?>/index.php?page=listings" class="btn btn-ghost btn-sm">← Back</a>
      </div>
    </div>

    <div class="card" style="max-width:700px">
      <div class="card-header"><h3>📋 Edit Details</h3></div>
      <div class="card-body">
        <form method="POST" action="<?= $base ?>/index.php?page=listings&action=update">
          <input type="hidden" name="id" value="<?= $listing['id'] ?>">

          <div class="form-group">
            <label class="form-label">Title <span class="req">*</span></label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($listing['title']) ?>" required>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Variety <span class="req">*</span></label>
              <select name="variety" class="form-control" required>
                <?php foreach(['Victoria','Kinigi White','Gishwati Red','Kirundo','Kachpot-1','Cruza','Other'] as $v): ?>
                  <option value="<?= $v ?>" <?= $listing['variety']===$v?'selected':'' ?>><?= $v ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Pickup Sector <span class="req">*</span></label>
              <select name="pickup_sector" class="form-control" required>
                <?php foreach($sectors as $s): ?>
                  <option value="<?= $s ?>" <?= $listing['pickup_sector']===$s?'selected':'' ?>><?= $s ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Quantity (kg) <span class="req">*</span></label>
              <input type="number" name="quantity_kg" class="form-control" value="<?= $listing['quantity_kg'] ?>" required min="1" step="0.5">
            </div>
            <div class="form-group">
              <label class="form-label">Price per kg (RWF) <span class="req">*</span></label>
              <input type="number" name="price_per_kg" class="form-control" value="<?= $listing['price_per_kg'] ?>" required min="1">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Harvest Date <span class="req">*</span></label>
              <input type="date" name="harvest_date" class="form-control" value="<?= $listing['harvest_date'] ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label">Expiry Date</label>
              <input type="date" name="expiry_date" class="form-control" value="<?= $listing['expiry_date'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($listing['description']) ?></textarea>
          </div>
          <div style="display:flex;gap:12px">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="<?= $base ?>/index.php?page=listings" class="btn btn-ghost">Cancel</a>
          </div>
        </form>
      </div>
    </div>

  </main>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
