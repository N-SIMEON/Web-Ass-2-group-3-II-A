<?php
$pageTitle = 'Manage Users';
$base = BASE_URL;
require_once ROOT . '/app/views/layouts/header.php';
?>

<div class="app-layout">
  <?php require_once ROOT . '/app/views/layouts/sidebar.php'; ?>
  <main class="main-content">

    <div class="page-header">
      <div class="page-header-inner">
        <div>
          <h1>👥 Platform Users</h1>
          <p class="page-subtitle">All registered farmers, buyers, and admins.</p>
        </div>
        <a href="<?= $base ?>/index.php?page=admin" class="btn btn-ghost btn-sm">← Dashboard</a>
      </div>
    </div>

    <div class="filters-bar">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="farmer">🌾 Farmers</button>
      <button class="filter-btn" data-filter="buyer">🛒 Buyers</button>
      <button class="filter-btn" data-filter="admin">⚙️ Admins</button>
    </div>

    <div class="card">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Role</th>
              <th>Sector</th>
              <th>Cooperative</th>
              <th>Joined</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $u): ?>
            <tr data-status="<?= $u['role'] ?>">
              <td><strong><?= htmlspecialchars($u['full_name']) ?></strong></td>
              <td style="font-size:.85rem"><?= htmlspecialchars($u['email']) ?></td>
              <td style="font-size:.85rem"><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
              <td><span class="badge badge-<?= $u['role'] ?>"><?= ucfirst($u['role']) ?></span></td>
              <td><?= htmlspecialchars($u['sector'] ?? '—') ?></td>
              <td><?= htmlspecialchars($u['coop_name'] ?? '—') ?></td>
              <td style="font-size:.82rem"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
              <td>
                <?php if ($u['is_active']): ?>
                  <span style="color:var(--success);font-size:.82rem;font-weight:600">● Active</span>
                <?php else: ?>
                  <span style="color:var(--danger);font-size:.82rem;font-weight:600">● Inactive</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>
</div>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
