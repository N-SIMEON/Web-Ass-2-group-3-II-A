<?php
/**
 * AgriStack — Layout Header
 * @var string $pageTitle
 */
$base = BASE_URL;
$role = $_SESSION['user_role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle ?? 'AgriStack') ?> — AgriStack</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="<?= $base ?>/../../assets/css/style.css">
  <meta name="description" content="AgriStack — Irish Potato Marketplace for Musanze cooperatives">
</head>
<body>

<nav class="navbar">
  <div class="navbar-inner">
    <a href="<?= $base ?>/index.php" class="navbar-brand">
      <div class="logo-icon">🥔</div>
      AgriStack
    </a>

    <?php if (isLoggedIn()): ?>
    <ul class="nav-links">
      <li><a href="<?= $base ?>/index.php?page=dashboard">🏠 Dashboard</a></li>
      <?php if ($role === 'farmer'): ?>
        <li><a href="<?= $base ?>/index.php?page=listings">📋 My Listings</a></li>
        <li><a href="<?= $base ?>/index.php?page=listings&action=create">＋ New Listing</a></li>
      <?php elseif ($role === 'buyer'): ?>
        <li><a href="<?= $base ?>/index.php?page=listings">🛒 Browse</a></li>
        <li><a href="<?= $base ?>/index.php?page=bookings">📦 My Orders</a></li>
      <?php elseif ($role === 'admin'): ?>
        <li><a href="<?= $base ?>/index.php?page=admin">⚙️ Admin</a></li>
        <li><a href="<?= $base ?>/index.php?page=admin&action=listings">📋 Listings</a></li>
        <li><a href="<?= $base ?>/index.php?page=admin&action=orders">📦 Orders</a></li>
        <li><a href="<?= $base ?>/index.php?page=admin&action=audit">🔍 Audit</a></li>
      <?php endif; ?>
    </ul>
    <div style="display:flex;align-items:center;gap:12px">
      <span class="nav-role-chip"><?= htmlspecialchars($role) ?></span>
      <a href="<?= $base ?>/index.php?page=logout" class="btn btn-ghost btn-sm" style="color:#fff;border-color:rgba(255,255,255,.3)">Logout</a>
    </div>
    <?php endif; ?>
    <button class="hamburger" id="hamburger">☰</button>
  </div>
</nav>
