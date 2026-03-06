<?php
$pageTitle = 'Register';
$base = BASE_URL;
require_once ROOT . '/app/views/layouts/header.php';
$error = flash('error');
?>

<div class="auth-wrap">
  <div class="auth-left">
    <div class="auth-brand">
      <div class="logo-icon" style="background:var(--harvest);color:var(--soil)">🥔</div>
      AgriStack
    </div>
    <div class="auth-tagline">
      "Join hundreds of Musanze cooperatives selling directly to Rwanda's biggest buyers."
    </div>
    <div class="auth-stats">
      <div><div class="auth-stat-n">Fair</div><div class="auth-stat-l">Prices</div></div>
      <div><div class="auth-stat-n">0%</div><div class="auth-stat-l">Middleman</div></div>
      <div><div class="auth-stat-n">24h</div><div class="auth-stat-l">Approval</div></div>
    </div>
  </div>

  <div class="auth-right" style="align-items:flex-start;overflow-y:auto">
    <div class="auth-box" style="padding:20px 0">
      <h2 class="auth-title">Create Account</h2>
      <p class="auth-sub">Join the AgriStack marketplace</p>

      <?php if ($error): ?>
        <div class="alert alert-error" data-auto-dismiss>⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="<?= $base ?>/index.php?page=register">
        <div class="form-group">
          <label class="form-label">I am a <span class="req">*</span></label>
          <select name="role" class="form-control" id="roleSelect">
            <option value="farmer" <?= (($_POST['role']??'')==='farmer')?'selected':'' ?>>🌾 Farmer / Cooperative</option>
            <option value="buyer"  <?= (($_POST['role']??'')==='buyer') ?'selected':'' ?>>🛒 Aggregator / Buyer</option>
          </select>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Full Name <span class="req">*</span></label>
            <input type="text" name="full_name" class="form-control" placeholder="Jean Uwimana"
                   value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-control" placeholder="+250 788..."
                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Email <span class="req">*</span></label>
          <input type="email" name="email" class="form-control" placeholder="jean@example.com"
                 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Password <span class="req">*</span></label>
          <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
        </div>
        <div class="form-group">
          <label class="form-label">Your Sector (Musanze)</label>
          <input type="text" name="sector" class="form-control" placeholder="e.g. Kinigi, Cyuve, Shingiro"
                 value="<?= htmlspecialchars($_POST['sector'] ?? '') ?>">
        </div>
        <div class="form-group" id="coopGroup">
          <label class="form-label">Cooperative Name <small>(if applicable)</small></label>
          <input type="text" name="coop_name" class="form-control" placeholder="e.g. Kinigi Potato Coop"
                 value="<?= htmlspecialchars($_POST['coop_name'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px">
          Create Account →
        </button>
      </form>
      <p style="text-align:center;margin-top:18px;font-size:.875rem;color:var(--text-mid)">
        Already registered? <a href="<?= $base ?>/index.php?page=login" style="color:var(--leaf);font-weight:600">Sign in</a>
      </p>
    </div>
  </div>
</div>

<script>
const roleSelect = document.getElementById('roleSelect');
const coopGroup  = document.getElementById('coopGroup');
roleSelect.addEventListener('change', () => {
  coopGroup.style.display = roleSelect.value === 'farmer' ? '' : 'none';
});
roleSelect.dispatchEvent(new Event('change'));
</script>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
