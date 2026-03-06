/**
 * AgriStack — Main JavaScript
 */

// ── Live booking total estimator ───────────────────────
function initEstimator() {
  const qtyInput   = document.getElementById('qty_requested');
  const priceInput = document.getElementById('price_per_kg_hidden');
  const display    = document.getElementById('total_estimate');
  const breakdown  = document.getElementById('estimate_breakdown');
  const maxQty     = document.getElementById('max_qty');

  if (!qtyInput || !display) return;

  const pricePerKg = parseFloat(priceInput?.value || 0);
  const max        = parseFloat(maxQty?.value || 99999);

  function update() {
    const qty   = parseFloat(qtyInput.value) || 0;
    const total = qty * pricePerKg;

    display.textContent = new Intl.NumberFormat('en-RW', {
      style: 'currency', currency: 'RWF', maximumFractionDigits: 0
    }).format(total);

    if (breakdown) {
      breakdown.textContent = qty > 0
        ? `${qty} kg × ${pricePerKg.toLocaleString()} RWF/kg`
        : 'Enter quantity to see estimate';
    }

    // Warn if over max
    const warn = document.getElementById('qty_warn');
    if (warn) {
      warn.style.display = qty > max ? 'block' : 'none';
    }
  }

  qtyInput.addEventListener('input', update);
  update();
}

// ── Sidebar toggle (mobile) ────────────────────────────
function initSidebar() {
  const hamburger = document.getElementById('hamburger');
  const sidebar   = document.getElementById('sidebar');
  if (!hamburger || !sidebar) return;

  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('open');
  });

  document.addEventListener('click', (e) => {
    if (!sidebar.contains(e.target) && e.target !== hamburger) {
      sidebar.classList.remove('open');
    }
  });
}

// ── Status filter ──────────────────────────────────────
function initFilters() {
  document.querySelectorAll('.filter-btn[data-filter]').forEach(btn => {
    btn.addEventListener('click', () => {
      const filter = btn.dataset.filter;
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      document.querySelectorAll('[data-status]').forEach(row => {
        row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
      });
    });
  });
}

// ── Auto-dismiss alerts ─────────────────────────────────
function initAlerts() {
  document.querySelectorAll('.alert[data-auto-dismiss]').forEach(el => {
    setTimeout(() => {
      el.style.opacity = '0';
      el.style.transition = 'opacity .5s';
      setTimeout(() => el.remove(), 500);
    }, 4000);
  });
}

// ── Confirm dialogs ────────────────────────────────────
function initConfirm() {
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', (e) => {
      if (!confirm(el.dataset.confirm)) e.preventDefault();
    });
  });
}

// ── Animate stat numbers ───────────────────────────────
function animateNumbers() {
  document.querySelectorAll('.stat-number[data-target]').forEach(el => {
    const target = parseFloat(el.dataset.target);
    const isFloat = el.dataset.float === 'true';
    let current = 0;
    const step = target / 40;
    const timer = setInterval(() => {
      current = Math.min(current + step, target);
      el.textContent = isFloat
        ? current.toLocaleString('en-RW', { maximumFractionDigits: 0 })
        : Math.floor(current).toLocaleString();
      if (current >= target) clearInterval(timer);
    }, 25);
  });
}

// ── Sector bar widths ──────────────────────────────────
function initSectorBars() {
  document.querySelectorAll('.sector-fill[data-pct]').forEach(el => {
    setTimeout(() => {
      el.style.width = el.dataset.pct + '%';
    }, 300);
  });
}

// ── Init ───────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  initEstimator();
  initSidebar();
  initFilters();
  initAlerts();
  initConfirm();
  animateNumbers();
  initSectorBars();
});
