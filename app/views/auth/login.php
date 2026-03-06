<?php
$pageTitle = 'Login';
$base = BASE_URL;
require_once ROOT . '/app/views/layouts/header.php';
$error   = flash('error');
$success = flash('success');
?>

<div class="auth-wrap">
  <div class="auth-left">
    <div class="auth-brand">
      <div class="logo-icon" style="background:var(--harvest);color:var(--soil)">🥔</div>
      AgriStack
    </div>
    <div class="auth-tagline">
      "Connecting Musanze farmers directly to Rwanda's bulk buyers."
    </div>
    <div class="auth-stats">
      <div>
        <div class="auth-stat-n">500+</div>
        <div class="auth-stat-l">Farmers</div>
      </div>
      <div>
        <div class="auth-stat-n">12</div>
        <div class="auth-stat-l">Sectors</div>
      </div>
      <div>
        <div class="auth-stat-n">RWF 2M+</div>
        <div class="auth-stat-l">Monthly Volume</div>
      </div>
    </div>
  </div>

  <div class="auth-right">
    <div class="auth-box">
      <h2 class="auth-title">Welcome back</h2>
      <p class="auth-sub">Sign in to the AgriStack marketplace</p>

      <?php if ($error): ?>
        <div class="alert alert-error" data-auto-dismiss>⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="alert alert-success" data-auto-dismiss>✅ <?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <form method="POST" action="<?= $base ?>/index.php?page=login">
        <div class="form-group">
          <label class="form-label">Email <span class="req">*</span></label>
          <input type="email" name="email" class="form-control" placeholder="you@example.com"
                 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required autofocus>
        </div>
        <div class="form-group">
          <label class="form-label">Password <span class="req">*</span></label>
          <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px">
          Sign In →
        </button>
      </form>

      <p style="text-align:center;margin-top:20px;font-size:.875rem;color:var(--text-mid)">
        No account? <a href="<?= $base ?>/index.php?page=register" style="color:var(--leaf);font-weight:600">Register here</a>
      </p>

      <div style="margin-top:28px;padding:16px;background:var(--parchment);border-radius:10px;font-size:.78rem;color:var(--text-mid)">
        <strong style="color:var(--soil)">Demo accounts:</strong><br>
        Admin: admin@agristack.rw / password<br>
        Farmer: jean@agristack.rw / password<br>
        Buyer: robert@agristack.rw / password
      </div>
    </div>
  </div>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
