/* =====================================================
   WEDDING ADMIN — SHARED JAVASCRIPT
   ===================================================== */

// ─── Guest Data (Dummy) ─────────────────────────────
const GUESTS = [
  {
    name: "Ahmad Fauzi",
    status: "Hadir",
    jumlah: 2,
    pesan: "Semoga menjadi keluarga sakinah mawaddah warahmah",
    date: "2026-02-10"
  },
  {
    name: "Siti Nurhaliza",
    status: "Tidak Hadir",
    jumlah: 0,
    pesan: "Maaf tidak bisa hadir, semoga lancar sampai hari H",
    date: "2026-02-11"
  },
  {
    name: "Budi Santoso",
    status: "Hadir",
    jumlah: 3,
    pesan: "Selamat menempuh hidup baru!",
    date: "2026-02-12"
  },
  {
    name: "Dewi Rahayu",
    status: "Hadir",
    jumlah: 2,
    pesan: "Barakallahu lakuma wa baraka 'alaikuma wa jama'a bainakuma fi khair",
    date: "2026-02-13"
  },
  {
    name: "Riza Pratama",
    status: "Ragu-ragu",
    jumlah: 1,
    pesan: "Insya Allah akan diusahakan hadir, semoga diberi kemudahan",
    date: "2026-02-14"
  },
  {
    name: "Indah Permata",
    status: "Hadir",
    jumlah: 4,
    pesan: "Selamat & semoga pernikahan kalian penuh berkah dan kebahagiaan!",
    date: "2026-02-15"
  },
  {
    name: "Hendra Kusuma",
    status: "Tidak Hadir",
    jumlah: 0,
    pesan: "Mohon maaf berhalangan hadir. Doaku selalu menyertai kalian.",
    date: "2026-02-16"
  },
  {
    name: "Lestari Wulandari",
    status: "Hadir",
    jumlah: 2,
    pesan: "Semoga menjadi pasangan yang selalu saling mendukung!",
    date: "2026-02-17"
  }
];

// ─── Default Wedding Data ────────────────────────────
const DEFAULT_WEDDING = {
  groomName: "Rizky Aditya Pratama",
  brideName: "Annisa Maharani Putri",
  groomFather: "Bapak Hadi Santoso",
  groomMother: "Ibu Sri Wahyuni",
  brideFather: "Bapak Agus Setiawan",
  brideMother: "Ibu Yuli Astuti",
  weddingDay: "Sabtu",
  weddingDate: "14",
  weddingMonth: "Maret",
  weddingYear: "2026",
  akadLocation: "Masjid Al-Ikhlas, Jl. Mawar No. 12, Jakarta Selatan",
  akadTime: "08.00 – 10.00 WIB",
  receptionLocation: "Gedung Pesona Nusantara, Jl. Melati Raya No. 45, Jakarta Selatan",
  receptionTime: "11.00 – 14.00 WIB"
};

// ─── Storage Helpers ─────────────────────────────────
const Storage = {
  get: (key, fallback = null) => {
    try {
      const raw = localStorage.getItem(key);
      return raw ? JSON.parse(raw) : fallback;
    } catch { return fallback; }
  },
  set: (key, value) => {
    try { localStorage.setItem(key, JSON.stringify(value)); return true; }
    catch { return false; }
  }
};

// ─── 1. Fake Login ────────────────────────────────────
function initLogin() {
  const form = document.getElementById('loginForm');
  if (!form) return;

  const btn  = document.getElementById('loginBtn');
  const errEl = document.getElementById('loginError');

  form.addEventListener('submit', e => {
    e.preventDefault();
    const user = document.getElementById('username').value.trim();
    const pass = document.getElementById('password').value;

    if (errEl) errEl.style.display = 'none';

    // Simulate loading
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Signing in…';

    setTimeout(() => {
      if (user === '' || pass === '') {
        showLoginError('Please fill in both fields.');
        resetBtn();
        return;
      }
      // Any credentials work for demo
      btn.innerHTML = '✦ Welcome';
      setTimeout(() => { window.location.href = 'dashboard.html'; }, 600);
    }, 900);
  });

  function showLoginError(msg) {
    if (errEl) { errEl.textContent = msg; errEl.style.display = 'flex'; }
  }
  function resetBtn() {
    btn.disabled = false;
    btn.innerHTML = 'Enter Admin Panel';
  }
}

// ─── 2. Render Guest Table ────────────────────────────
function initDashboard() {
  const tbody = document.getElementById('guestTableBody');
  if (!tbody) return;

  renderTable(GUESTS);
  updateStats(GUESTS);

  // Search
  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      const q = searchInput.value.toLowerCase();
      const filtered = GUESTS.filter(g =>
        g.name.toLowerCase().includes(q) ||
        g.pesan.toLowerCase().includes(q) ||
        g.status.toLowerCase().includes(q)
      );
      renderTable(filtered);
    });
  }

  // Filter
  const filterSelect = document.getElementById('filterStatus');
  if (filterSelect) {
    filterSelect.addEventListener('change', () => {
      const val = filterSelect.value;
      const filtered = val === 'all' ? GUESTS : GUESTS.filter(g => g.status === val);
      renderTable(filtered);
    });
  }
}

function renderTable(data) {
  const tbody = document.getElementById('guestTableBody');
  if (!tbody) return;

  if (data.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);font-style:italic;">
          No guests found
        </td>
      </tr>`;
    return;
  }

  tbody.innerHTML = data.map((g, i) => {
    const badgeClass = g.status === 'Hadir' ? 'badge-hadir'
                     : g.status === 'Tidak Hadir' ? 'badge-tidak'
                     : 'badge-ragu';
    const icon = g.status === 'Hadir' ? '♥' : g.status === 'Tidak Hadir' ? '✕' : '?';
    const formattedDate = formatDate(g.date);

    return `
      <tr style="animation-delay:${i * 0.05}s" class="table-row-in">
        <td>
          <div style="font-weight:600;color:var(--brown-dark)">${escapeHtml(g.name)}</div>
        </td>
        <td><span class="badge ${badgeClass}">${icon} ${escapeHtml(g.status)}</span></td>
        <td style="text-align:center;font-size:18px;font-weight:600;color:var(--brown)">${g.jumlah}</td>
        <td style="max-width:260px;font-style:italic;color:var(--text-light);font-size:15px;">"${escapeHtml(g.pesan)}"</td>
        <td style="color:var(--text-muted);font-size:14px;white-space:nowrap">${formattedDate}</td>
      </tr>`;
  }).join('');
}

function updateStats(data) {
  const total  = data.length;
  const hadir  = data.filter(g => g.status === 'Hadir').length;
  const tidak  = data.filter(g => g.status === 'Tidak Hadir').length;
  const guests = data.reduce((s, g) => s + g.jumlah, 0);

  setEl('statTotal',  total);
  setEl('statHadir',  hadir);
  setEl('statTidak',  tidak);
  setEl('statGuests', guests);
}

// ─── 3. Edit Form ─────────────────────────────────────
function initEdit() {
  const form = document.getElementById('editForm');
  if (!form) return;

  const saved = Storage.get('weddingData', DEFAULT_WEDDING);
  populateForm(saved);

  form.addEventListener('submit', e => {
    e.preventDefault();
    saveEditForm();
  });

  // Reset button
  const resetBtn = document.getElementById('resetBtn');
  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      if (confirm('Reset to default data?')) {
        populateForm(DEFAULT_WEDDING);
        showToast('✦', 'Form reset to default values');
      }
    });
  }
}

function populateForm(data) {
  Object.keys(data).forEach(key => {
    const el = document.getElementById(key);
    if (el) el.value = data[key];
  });
}

// ─── 4. Save Edit Form ────────────────────────────────
function saveEditForm() {
  const fields = [
    'groomName','brideName','groomFather','groomMother',
    'brideFather','brideMother','weddingDay','weddingDate',
    'weddingMonth','weddingYear','akadLocation','akadTime',
    'receptionLocation','receptionTime'
  ];

  const data = {};
  fields.forEach(id => {
    const el = document.getElementById(id);
    if (el) data[id] = el.value;
  });

  const saveBtn = document.getElementById('saveBtn');
  if (saveBtn) {
    saveBtn.disabled = true;
    saveBtn.innerHTML = '✦ Saving…';
  }

  setTimeout(() => {
    // 5. Save to localStorage
    const ok = Storage.set('weddingData', data);
    if (saveBtn) { saveBtn.disabled = false; saveBtn.innerHTML = '✦ Save Changes'; }
    if (ok) {
      showToast('✦', 'Wedding details saved successfully!');
      showSaveConfirmation(data);
    } else {
      showToast('⚠', 'Could not save — localStorage unavailable');
    }
  }, 800);
}

function showSaveConfirmation(data) {
  const preview = document.getElementById('savePreview');
  if (!preview) return;
  preview.innerHTML = `
    <div class="save-preview-inner">
      <p class="font-script" style="font-size:28px;color:var(--gold)">
        ${escapeHtml(data.brideName)} &amp; ${escapeHtml(data.groomName)}
      </p>
      <p style="font-size:14px;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-muted);margin-top:4px">
        ${escapeHtml(data.weddingDay)}, ${escapeHtml(data.weddingDate)} ${escapeHtml(data.weddingMonth)} ${escapeHtml(data.weddingYear)}
      </p>
    </div>`;
  preview.style.display = 'block';
  setTimeout(() => {
    preview.style.opacity = '1';
    preview.style.transform = 'translateY(0)';
  }, 50);
}

// ─── 5. Toast Notification ───────────────────────────
function showToast(icon, message) {
  let container = document.getElementById('toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.innerHTML = `<span class="toast-icon">${icon}</span><span>${message}</span>`;
  container.appendChild(toast);

  // Trigger show
  requestAnimationFrame(() => {
    requestAnimationFrame(() => toast.classList.add('show'));
  });

  setTimeout(() => {
    toast.classList.remove('show');
    toast.classList.add('hide');
    setTimeout(() => toast.remove(), 500);
  }, 3200);
}

// ─── Utilities ───────────────────────────────────────
function escapeHtml(str) {
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function formatDate(dateStr) {
  try {
    const d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
  } catch { return dateStr; }
}

function setEl(id, val) {
  const el = document.getElementById(id);
  if (el) el.textContent = val;
}

// ─── Nav Active State ─────────────────────────────────
function setActiveNav() {
  const page = window.location.pathname.split('/').pop() || 'dashboard.html';
  document.querySelectorAll('.nav-link[data-page]').forEach(link => {
    link.classList.toggle('active', link.dataset.page === page);
  });
}

// ─── Page Load Animation ──────────────────────────────
function fadeInPage() {
  document.body.style.opacity = '0';
  document.body.style.transition = 'opacity 0.5s ease';
  requestAnimationFrame(() => {
    requestAnimationFrame(() => { document.body.style.opacity = '1'; });
  });
}

// ─── Navigate with fade ───────────────────────────────
function navigateTo(url) {
  document.body.style.transition = 'opacity 0.35s ease';
  document.body.style.opacity = '0';
  setTimeout(() => { window.location.href = url; }, 350);
}

// ─── Bootstrap on DOMContentLoaded ───────────────────
document.addEventListener('DOMContentLoaded', () => {
  fadeInPage();
  setActiveNav();
  initLogin();
  initDashboard();
  initEdit();

  // Wire nav logout
  document.querySelectorAll('[data-action="logout"]').forEach(el => {
    el.addEventListener('click', e => {
      e.preventDefault();
      if (confirm('Logout from Admin Panel?')) navigateTo('login.html');
    });
  });

  // Wire nav navigate links with smooth fade
  document.querySelectorAll('[data-nav]').forEach(el => {
    el.addEventListener('click', e => {
      e.preventDefault();
      navigateTo(el.dataset.nav);
    });
  });
});