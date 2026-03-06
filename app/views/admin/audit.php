<?php
$pageTitle = 'Audit Log';
$base = BASE_URL;
require_once ROOT . '/app/views/layouts/header.php';
?>

<div class="app-layout">
  <?php require_once ROOT . '/app/views/layouts/sidebar.php'; ?>
  <main class="main-content">

    <div class="page-header">
      <div class="page-header-inner">
        <div>
          <h1>🔍 Audit Log</h1>
          <p class="page-subtitle">Full platform activity history · <?= number_format($count) ?> total records</p>
        </div>
        <a href="<?= $base ?>/index.php?page=admin" class="btn btn-ghost btn-sm">← Dashboard</a>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3>Recent Activity</h3>
        <span style="font-size:.82rem;color:var(--text-mid)">Showing last <?= count($logs) ?> records</span>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Timestamp</th>
              <th>User</th>
              <th>Action</th>
              <th>Entity</th>
              <th>Details</th>
              <th>IP Address</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($logs)): ?>
              <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-mid)">No audit records yet.</td></tr>
            <?php else: ?>
              <?php foreach ($logs as $log): ?>
              <tr>
                <td style="white-space:nowrap;font-size:.82rem">
                  <?= date('d M Y', strtotime($log['created_at'])) ?><br>
                  <span style="color:var(--text-lite)"><?= date('H:i:s', strtotime($log['created_at'])) ?></span>
                </td>
                <td>
                  <strong style="font-size:.875rem"><?= htmlspecialchars($log['user_name'] ?? 'System') ?></strong>
                </td>
                <td>
                  <span style="font-weight:600;font-size:.875rem"><?= htmlspecialchars($log['action']) ?></span>
                </td>
                <td>
                  <?php if ($log['entity_type']): ?>
                    <span style="text-transform:capitalize;background:var(--parchment);padding:2px 8px;border-radius:4px;font-size:.78rem">
                      <?= htmlspecialchars($log['entity_type']) ?>
                      <?php if ($log['entity_id']): ?> #<?= $log['entity_id'] ?><?php endif; ?>
                    </span>
                  <?php endif; ?>
                </td>
                <td style="max-width:260px;font-size:.82rem;color:var(--text-mid)">
                  <?= htmlspecialchars($log['details']) ?>
                </td>
                <td style="font-size:.78rem;color:var(--text-lite);font-family:monospace">
                  <?= htmlspecialchars($log['ip_address']) ?>
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
