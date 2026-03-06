<?php
$base = BASE_URL;
$role = $_SESSION['user_role'] ?? '';
$cur  = $_GET['page'] ?? 'dashboard';
$act  = $_GET['action'] ?? '';
?>
<aside class="sidebar" id="sidebar">
  <div style="padding:0 8px 16px;border-bottom:1px solid var(--border);margin-bottom:16px;">
    <div style="font-size:.8rem;color:var(--text-lite)">Signed in as</div>
    <div style="font-weight:600;color:var(--soil);font-size:.9rem;margin-top:2px"><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></div>
    <span class="badge badge-<?= $role ?>" style="margin-top:4px"><?= ucfirst($role) ?></span>
  </div>

  <?php if ($role === 'farmer'): ?>
    <div class="sidebar-section">
      <div class="sidebar-label">Farmer</div>
      <a href="<?= $base ?>/index.php?page=dashboard" class="<?= $cur==='dashboard'?'active':'' ?>"><span class="icon">🏠</span> Dashboard</a>
      <a href="<?= $base ?>/index.php?page=listings" class="<?= ($cur==='listings'&&$act==='')? 'active':'' ?>"><span class="icon">📋</span> My Listings</a>
      <a href="<?= $base ?>/index.php?page=listings&action=create" class="<?= $act==='create'?'active':'' ?>"><span class="icon">＋</span> New Listing</a>
    </div>

  <?php elseif ($role === 'buyer'): ?>
    <div class="sidebar-section">
      <div class="sidebar-label">Buyer</div>
      <a href="<?= $base ?>/index.php?page=dashboard" class="<?= $cur==='dashboard'?'active':'' ?>"><span class="icon">🏠</span> Dashboard</a>
      <a href="<?= $base ?>/index.php?page=listings" class="<?= $cur==='listings'?'active':'' ?>"><span class="icon">🛒</span> Browse Market</a>
      <a href="<?= $base ?>/index.php?page=bookings" class="<?= $cur==='bookings'?'active':'' ?>"><span class="icon">📦</span> My Orders</a>
    </div>

  <?php elseif ($role === 'admin'): ?>
    <div class="sidebar-section">
      <div class="sidebar-label">Admin</div>
      <a href="<?= $base ?>/index.php?page=admin" class="<?= ($cur==='admin'&&!$act)?'active':'' ?>"><span class="icon">📊</span> Overview</a>
      <a href="<?= $base ?>/index.php?page=admin&action=listings" class="<?= $act==='listings'?'active':'' ?>"><span class="icon">📋</span> Listings</a>
      <a href="<?= $base ?>/index.php?page=admin&action=orders" class="<?= $act==='orders'?'active':'' ?>"><span class="icon">📦</span> Orders</a>
      <a href="<?= $base ?>/index.php?page=admin&action=users" class="<?= $act==='users'?'active':'' ?>"><span class="icon">👥</span> Users</a>
      <a href="<?= $base ?>/index.php?page=admin&action=audit" class="<?= $act==='audit'?'active':'' ?>"><span class="icon">🔍</span> Audit Log</a>
    </div>
  <?php endif; ?>

  <div class="sidebar-section" style="margin-top:auto;padding-top:16px;border-top:1px solid var(--border)">
    <a href="<?= $base ?>/index.php?page=logout"><span class="icon">🚪</span> Logout</a>
  </div>
</aside>
