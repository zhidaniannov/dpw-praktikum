<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../login.php');
  exit;
}
require_once '../koneksi.php';

// HANDLE DELETE RSVP IN THE SAME FILE FOR SIMPLICITY
if (isset($_POST['action']) && $_POST['action'] === 'delete_rsvp') {
  $id = (int)($_POST['reservation_id'] ?? 0);
  if ($id > 0) {
    mysqli_query($koneksi, "DELETE FROM reservations WHERE reservation_id=$id");
  }
  header('Location: dashboard.php?deleted=1');
  exit;
}

// FETCH GUESTS
$guests = [];
$resultG = mysqli_query($koneksi, "SELECT * FROM guests ORDER BY guest_id DESC");
if ($resultG) {
  while ($row = mysqli_fetch_assoc($resultG)) {
    $guests[] = $row;
  }
}
$totalGuests = count($guests);

// FETCH RSVPS
$rsvps = [];
$resultR = mysqli_query($koneksi, "SELECT * FROM reservations ORDER BY reservation_id DESC");
if ($resultR) {
  while ($row = mysqli_fetch_assoc($resultR)) {
    $rsvps[] = $row;
  }
}
$totalRsvps = count($rsvps);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Dashboard — Wedding Admin</title>
<link rel="stylesheet" href="style.css" />
<style>
/* ── Sidebar Layout Overrides ───────────────────── */
body { margin: 0; padding: 0; }
.admin-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
@media (min-width: 800px) {
  .admin-layout { flex-direction: row; }
  .sidebar { width: 260px; height: 100vh; position: sticky; top: 0; }
}
.sidebar {
  background: linear-gradient(135deg, var(--brown-dark) 0%, var(--brown) 100%);
  color: var(--white);
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  box-shadow: 4px 0 24px rgba(90,62,37,0.25);
  z-index: 10;
}
.sidebar-logo {
  padding: 32px 24px;
  text-align: center;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.sidebar-logo .brand {
  font-family: 'Great Vibes', cursive;
  font-size: 38px;
  color: var(--gold-pale);
  text-shadow: 0 1px 4px rgba(0,0,0,0.20);
  margin: 0; line-height: 1;
}
.sidebar-logo .subtitle {
  font-family: 'Playfair Display', serif;
  font-size: 11px;
  letter-spacing: 0.25em;
  text-transform: uppercase;
  color: rgba(240,216,154,0.70);
  margin-top: 8px; display: block;
}
.sidebar-menu {
  list-style: none;
  padding: 24px 16px;
  flex: 1;
}
.sidebar-menu li { margin-bottom: 8px; }
.sidebar-menu a {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 20px;
  color: rgba(253,246,236,0.80);
  text-decoration: none;
  border-radius: 12px;
  font-family: 'Cormorant Garamond', serif;
  font-size: 17px;
  font-weight: 600;
  transition: var(--transition);
  cursor: pointer;
}
.sidebar-menu a.active, .sidebar-menu a:hover {
  background: rgba(201,148,58,0.22);
  color: var(--gold-pale);
}
.sidebar-menu .icon { font-size: 20px; }
.sidebar-footer {
  padding: 24px 16px;
  border-top: 1px solid rgba(255,255,255,0.08);
}
.sidebar-footer a {
  display: flex; justify-content: center;
  background: rgba(0,0,0,0.2);
}
.sidebar-footer a:hover { background: rgba(0,0,0,0.4); }

.main-content {
  flex: 1;
  padding: 36px 40px;
  background: var(--cream);
  overflow-y: auto;
}

/* ── Hide old top navs ──────────────────────────── */
.nav-banner, .admin-nav { display: none !important; }

/* ── Content specific ───────────────────────────── */
.content-section {
  background: var(--white);
  border: 1px solid rgba(201,148,58,0.18);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-md);
  padding: 28px 32px;
}
.dashboard-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
  margin-bottom: 28px;
}
.stat-banner {
  background: linear-gradient(135deg, var(--brown-dark) 0%, var(--brown) 100%);
  border-radius: var(--radius-md);
  padding: 28px 36px;
  display: flex;
  align-items: center;
  gap: 20px;
  box-shadow: var(--shadow-md);
}
.stat-banner.rsvp-stat {
  background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
}
.stat-banner.rsvp-stat .stat-value { color: var(--brown-dark); }
.stat-banner.rsvp-stat .stat-label { color: rgba(90,62,37,0.8); }
.stat-banner .stat-icon {
  width: 60px; height: 60px;
  border-radius: 50%;
  background: rgba(201,148,58,0.25);
  display: flex; align-items: center; justify-content: center;
  font-size: 26px;
  flex-shrink: 0;
}
.stat-banner.rsvp-stat .stat-icon { background: rgba(255,255,255,0.3); color: var(--brown-dark); }
.stat-banner .stat-value {
  font-family: 'Playfair Display', serif;
  font-size: 42px;
  font-weight: 700;
  color: var(--gold-pale);
  line-height: 1;
}
.stat-banner .stat-label {
  font-size: 13px;
  letter-spacing: 0.10em;
  text-transform: uppercase;
  color: rgba(240,216,154,0.70);
  margin-top: 4px;
}

/* ── Toolbar ────────────────────────────────────── */
.toolbar {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}
.search-wrap {
  position: relative;
  flex: 1;
  min-width: 160px;
  max-width: 260px;
}
.search-wrap .search-icon {
  position: absolute;
  left: 14px; top: 50%;
  transform: translateY(-50%);
  color: var(--text-muted);
  font-size: 15px;
  pointer-events: none;
}
.search-wrap .form-input { padding-left: 38px; }

/* ── Modal ──────────────────────────────────────── */
.modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(74,53,32,0.50);
  backdrop-filter: blur(4px);
  z-index: 500;
  align-items: center;
  justify-content: center;
}
.modal-overlay.open { display: flex; }
.modal-box {
  background: var(--white);
  border: 1px solid rgba(201,148,58,0.25);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-lg);
  width: 100%;
  max-width: 440px;
  padding: 36px 40px 30px;
  position: relative;
  animation: slideUp 0.28s cubic-bezier(0.4,0,0.2,1);
}
@keyframes slideUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}
.modal-close {
  position: absolute;
  top: 16px; right: 20px;
  font-size: 18px;
  cursor: pointer;
  color: var(--text-muted);
  background: none; border: none;
  transition: var(--transition);
}
.modal-close:hover { color: var(--brown); }
.modal-title {
  font-family: 'Great Vibes', cursive;
  font-size: 32px;
  color: var(--gold);
  margin-bottom: 20px;
  text-align: center;
}

/* ── Row action buttons ─────────────────────────── */
.btn-sm {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 5px 14px;
  border-radius: 50px;
  font-family: 'Cormorant Garamond', serif;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  transition: var(--transition);
}
.btn-edit         { background: #dce8f5; color: #1a5276; }
.btn-edit:hover   { background: #b8d4ee; }
.btn-delete       { background: #fde8e8; color: #a93226; }
.btn-delete:hover { background: #f5c6c6; }
.action-btns { display: flex; gap: 6px; justify-content: center; }

/* ── Empty / no-result state ────────────────────── */
.empty-state {
  text-align: center;
  padding: 44px 20px;
  color: var(--text-muted);
  font-style: italic;
}
.col-num { color: var(--text-muted); font-size: 13px; width: 48px; }

@media (max-width: 800px) {
  .main-content { padding: 24px 16px; }
  .content-section { padding: 20px 16px; }
  .stat-banner { padding: 20px; }
  .sidebar { flex-direction: row; height: auto; position: static; align-items: center; justify-content: space-between; }
  .sidebar-logo { padding: 16px; border: none; }
  .sidebar-logo .brand { font-size: 28px; }
  .sidebar-menu { display: flex; padding: 10px; overflow-x: auto; margin: 0; }
  .sidebar-menu li { margin: 0; }
  .sidebar-menu a { padding: 8px 12px; font-size: 14px; white-space: nowrap; }
  .sidebar-footer { padding: 10px; border: none; }
  .dashboard-stats { grid-template-columns: 1fr; }
}
</style>
</head>

<body class="bg-texture admin-layout">

  <!-- ── Professional Sidebar ── -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <h1 class="brand">Wedding</h1>
      <span class="subtitle">Admin Panel</span>
    </div>
    
    <ul class="sidebar-menu">
      <li>
        <a onclick="switchView('view-guests', this, 'Guest List')" class="active">
          <span class="icon">👥</span>
          <span>Guest List</span>
        </a>
      </li>
      <li>
        <a onclick="switchView('view-rsvps', this, 'RSVP Responses')">
          <span class="icon">💌</span>
          <span>RSVP Responses</span>
        </a>
      </li>
      <li>
        <a href="edit.php">
          <span class="icon">✎</span>
          <span>Edit Page</span>
        </a>
      </li>
    </ul>

    <div class="sidebar-footer">
      <a href="../logout.php" class="nav-link">
        <span class="icon">⇥</span>
        <span>Logout</span>
      </a>
    </div>
  </aside>

  <!-- ── Main Content Area ── -->
  <main class="main-content">
    
    <header class="page-header" style="padding: 10px 0 36px; text-align: left;">
      <span class="script-title" id="pageHeaderTitle" style="font-size: 48px; text-align: left;">Guest List</span>
      <p class="serif-subtitle" style="text-align: left; margin-top: 6px;">Manage Your Wedding Invitations</p>
      <div class="divider" style="max-width: 200px; margin: 12px 0 0;">
        <span class="divider-icon">✦</span>
      </div>
    </header>

    <!-- ── Stat banners ── -->
    <div class="dashboard-stats">
      <div class="stat-banner">
        <div class="stat-icon">👥</div>
        <div>
          <div class="stat-value"><?= $totalGuests ?></div>
          <div class="stat-label">Total Tamu Undangan</div>
        </div>
      </div>
      <div class="stat-banner rsvp-stat">
        <div class="stat-icon">💌</div>
        <div>
          <div class="stat-value"><?= $totalRsvps ?></div>
          <div class="stat-label">Total RSVP Masuk</div>
        </div>
      </div>
    </div>

    <!-- ============================================== -->
    <!-- VIEW: GUEST LIST                               -->
    <!-- ============================================== -->
    <div id="view-guests" class="view-section">
      <div class="content-section">
        <div class="toolbar">
          <div class="section-title" style="flex:1">Tabel Tamu</div>
          <div class="search-wrap">
            <span class="search-icon">⌕</span>
            <input
              type="text"
              id="searchInputGuest"
              class="form-input"
              placeholder="Cari nama tamu…"
              autocomplete="off"
            />
          </div>
          <button class="btn btn-primary" id="btnAdd">+ Tambah Tamu</button>
        </div>

        <div class="table-wrapper">
          <table class="elegant-table">
            <thead>
              <tr>
                <th class="col-num">#</th>
                <th>Nama Tamu</th>
                <th style="text-align:center">Aksi</th>
              </tr>
            </thead>
            <tbody id="guestTableBody">
              <?php if ($totalGuests > 0): ?>
                <?php foreach ($guests as $i => $g): ?>
                  <tr class="search-row-guest" data-name="<?= htmlspecialchars(strtolower($g['name'])) ?>">
                    <td class="col-num"><?= $i + 1 ?></td>
                    <td style="font-weight:600;color:var(--brown-dark);font-size:17px">
                      <?= htmlspecialchars($g['name']) ?>
                    </td>
                    <td>
                      <div class="action-btns">
                        <button
                          class="btn-sm btn-edit"
                          onclick="openEditModal(<?= $g['guest_id'] ?>, '<?= htmlspecialchars(addslashes($g['name'])) ?>')"
                        >✎ Edit</button>
                        <button
                          class="btn-sm btn-delete"
                          onclick="openDeleteModal(<?= $g['guest_id'] ?>, '<?= htmlspecialchars(addslashes($g['name'])) ?>')"
                        >✕ Hapus</button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr id="emptyDbRowGuest">
                  <td colspan="3">
                    <div class="empty-state">Belum ada data tamu undangan</div>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


    <!-- ============================================== -->
    <!-- VIEW: RSVPs                                    -->
    <!-- ============================================== -->
    <div id="view-rsvps" class="view-section" style="display: none;">
      <div class="content-section">
        <div class="toolbar">
          <div class="section-title" style="flex:1">Tabel Konfirmasi RSVP</div>
          <div class="search-wrap">
            <span class="search-icon">⌕</span>
            <input
              type="text"
              id="searchInputRsvp"
              class="form-input"
              placeholder="Cari konfirmasi…"
              autocomplete="off"
            />
          </div>
        </div>

        <div class="table-wrapper">
          <table class="elegant-table">
            <thead>
              <tr>
                <th class="col-num">#</th>
                <th>Nama Tamu</th>
                <th>Kehadiran</th>
                <th>Jumlah (Pax)</th>
                <th style="text-align:center">Aksi</th>
              </tr>
            </thead>
            <tbody id="rsvpTableBody">
              <?php if ($totalRsvps > 0): ?>
                <?php foreach ($rsvps as $i => $r): ?>
                  <tr class="search-row-rsvp" data-name="<?= htmlspecialchars(strtolower($r['name'])) ?>">
                    <td class="col-num"><?= $i + 1 ?></td>
                    <td style="font-weight:600;color:var(--brown-dark);font-size:17px">
                      <?= htmlspecialchars($r['name']) ?>
                    </td>
                    <td>
                      <?php if ($r['option'] === 'H'): ?>
                        <span class="badge badge-hadir">Hadir</span>
                      <?php else: ?>
                        <span class="badge badge-tidak">Tidak Hadir</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?= ($r['option'] === 'H') ? htmlspecialchars($r['member']) . ' Pax' : '-' ?>
                    </td>
                    <td>
                      <div class="action-btns">
                        <button
                          class="btn-sm btn-delete"
                          onclick="openDeleteRsvpModal(<?= $r['reservation_id'] ?>, '<?= htmlspecialchars(addslashes($r['name'])) ?>')"
                        >✕ Hapus</button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr id="emptyDbRowRsvp">
                  <td colspan="5">
                    <div class="empty-state">Belum ada RSVP yang masuk</div>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </main>

  <!-- ══════════ ADD MODAL ══════════ -->
  <div class="modal-overlay" id="addModal">
    <div class="modal-box">
      <button class="modal-close" onclick="closeModal('addModal')">✕</button>
      <div class="modal-title">Tambah Tamu</div>
      <form method="POST" action="guest_action.php">
        <input type="hidden" name="action" value="add" />
        <div class="form-group">
          <label class="form-label">Nama Tamu</label>
          <input
            type="text"
            name="name"
            class="form-input"
            placeholder="Masukkan nama tamu…"
            maxlength="25"
            required
            autofocus
          />
          <span style="font-size:12px;color:var(--text-muted);margin-top:2px">Maks. 25 karakter</span>
        </div>
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:8px">
          <button type="button" class="btn btn-outline" onclick="closeModal('addModal')">Batal</button>
          <button type="submit" class="btn btn-primary">✦ Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ══════════ EDIT MODAL ══════════ -->
  <div class="modal-overlay" id="editModal">
    <div class="modal-box">
      <button class="modal-close" onclick="closeModal('editModal')">✕</button>
      <div class="modal-title">Edit Tamu</div>
      <form method="POST" action="guest_action.php">
        <input type="hidden" name="action" value="edit" />
        <input type="hidden" name="guest_id" id="editGuestId" />
        <div class="form-group">
          <label class="form-label">Nama Tamu</label>
          <input
            type="text"
            name="name"
            id="editGuestName"
            class="form-input"
            maxlength="25"
            required
          />
          <span style="font-size:12px;color:var(--text-muted);margin-top:2px">Maks. 25 karakter</span>
        </div>
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:8px">
          <button type="button" class="btn btn-outline" onclick="closeModal('editModal')">Batal</button>
          <button type="submit" class="btn btn-primary">✦ Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ══════════ DELETE GUEST MODAL ══════════ -->
  <div class="modal-overlay" id="deleteModal">
    <div class="modal-box" style="max-width:380px;text-align:center">
      <button class="modal-close" onclick="closeModal('deleteModal')">✕</button>
      <div style="font-size:40px;margin-bottom:10px">🗑</div>
      <h3 style="font-family:'Playfair Display',serif;font-size:20px;color:var(--brown-dark);margin-bottom:8px">
        Hapus Tamu?
      </h3>
      <p id="deleteLabel" style="color:var(--text-light);margin-bottom:24px;font-style:italic;font-size:17px"></p>
      <form method="POST" action="guest_action.php">
        <input type="hidden" name="action" value="delete" />
        <input type="hidden" name="guest_id" id="deleteGuestId" />
        <div style="display:flex;gap:12px;justify-content:center">
          <button type="button" class="btn btn-outline" onclick="closeModal('deleteModal')">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ══════════ DELETE RSVP MODAL ══════════ -->
  <div class="modal-overlay" id="deleteRsvpModal">
    <div class="modal-box" style="max-width:380px;text-align:center">
      <button class="modal-close" onclick="closeModal('deleteRsvpModal')">✕</button>
      <div style="font-size:40px;margin-bottom:10px">🗑</div>
      <h3 style="font-family:'Playfair Display',serif;font-size:20px;color:var(--brown-dark);margin-bottom:8px">
        Hapus RSVP?
      </h3>
      <p id="deleteRsvpLabel" style="color:var(--text-light);margin-bottom:24px;font-style:italic;font-size:17px"></p>
      <form method="POST" action="dashboard.php">
        <input type="hidden" name="action" value="delete_rsvp" />
        <input type="hidden" name="reservation_id" id="deleteRsvpId" />
        <div style="display:flex;gap:12px;justify-content:center">
          <button type="button" class="btn btn-outline" onclick="closeModal('deleteRsvpModal')">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>

  <div id="toast-container"></div>
  <script src="script.js"></script>
  <script>
  /* ── Tab Switch Logic ────────────────────────────── */
  function switchView(viewId, el, title) {
    document.querySelectorAll('.view-section').forEach(sec => sec.style.display = 'none');
    document.getElementById(viewId).style.display = 'block';
    
    document.querySelectorAll('.sidebar-menu a').forEach(a => a.classList.remove('active'));
    el.classList.add('active');
    
    document.getElementById('pageHeaderTitle').textContent = title;
  }

  /* ── Modal helpers ───────────────────────────────── */
  function openModal(id)  { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }

  document.querySelectorAll('.modal-overlay').forEach(o => {
    o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); });
  });

  document.getElementById('btnAdd').addEventListener('click', () => openModal('addModal'));

  function openEditModal(id, name) {
    document.getElementById('editGuestId').value   = id;
    document.getElementById('editGuestName').value = name;
    openModal('editModal');
  }
  function openDeleteModal(id, name) {
    document.getElementById('deleteGuestId').value = id;
    document.getElementById('deleteLabel').textContent = '"' + name + '"';
    openModal('deleteModal');
  }
  function openDeleteRsvpModal(id, name) {
    document.getElementById('deleteRsvpId').value = id;
    document.getElementById('deleteRsvpLabel').textContent = '"' + name + '"';
    openModal('deleteRsvpModal');
  }

  /* ── Live search logic constructor ───────────────── */
  function setupLiveSearch(inputId, rowClass, bodyId, colSpan, emptyMsg) {
    document.getElementById(inputId).addEventListener('input', function () {
      const q = this.value.toLowerCase();
      let visible = 0;

      document.querySelectorAll('.' + rowClass).forEach(row => {
        const show = row.dataset.name.includes(q);
        row.style.display = show ? '' : 'none';
        if (show) visible++;
      });

      let noRow = document.getElementById('noResultRow_' + rowClass);
      if (visible === 0) {
        if (!noRow) {
          noRow = document.createElement('tr');
          noRow.id = 'noResultRow_' + rowClass;
          noRow.innerHTML = '<td colspan="' + colSpan + '"><div class="empty-state">' + emptyMsg + '</div></td>';
          document.getElementById(bodyId).appendChild(noRow);
        }
        noRow.style.display = '';
      } else if (noRow) {
        noRow.style.display = 'none';
      }
    });
  }

  setupLiveSearch('searchInputGuest', 'search-row-guest', 'guestTableBody', 3, 'Nama tamu tidak ditemukan');
  setupLiveSearch('searchInputRsvp', 'search-row-rsvp', 'rsvpTableBody', 5, 'Konfirmasi tidak ditemukan');

  /* ── Toast on redirect ───────────────────────────── */
  const p = new URLSearchParams(location.search);
  if (p.get('saved')   === '1') showToast('✦', 'Data berhasil disimpan!');
  if (p.get('deleted') === '1') showToast('✦', 'Data berhasil dihapus!');
  
  function showToast(icon, message) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = '<span class="toast-icon">' + icon + '</span><span>' + message + '</span>';
    container.appendChild(toast);
    
    // Animate in
    setTimeout(() => toast.classList.add('show'), 10);
    // Animate out
    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 400);
    }, 3500);
  }
  </script>

</body>
</html>