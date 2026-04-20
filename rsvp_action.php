<?php
/**
 * rsvp_action.php — place in project ROOT
 *
 * Layout:
 *   /koneksi.php
 *   /rsvp_action.php          ← this file
 *   /undangan/index.html
 *   /admin/dashboard.php
 */

header('Content-Type: application/json; charset=utf-8');

// Use the same require style as the rest of your project
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

/* ── Sanitise ────────────────────────────────────── */
$name   = trim($_POST['name']   ?? '');
$option = strtoupper(trim($_POST['option'] ?? ''));
$raw    = $_POST['member'] ?? null;

/* ── Validate ────────────────────────────────────── */
if ($name === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Nama tidak boleh kosong.']);
    exit;
}
if (!in_array($option, ['H', 'TH'], true)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Pilihan kehadiran tidak valid.']);
    exit;
}

$name   = mb_substr($name, 0, 25);
$member = null;
if ($option === 'H') {
    $member = max(1, (int) preg_replace('/[^0-9]/', '', (string) $raw));
}

/* ── Insert ──────────────────────────────────────── */
$stmt = mysqli_prepare($koneksi, "INSERT INTO reservations (name, `option`, member) VALUES (?, ?, ?)");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB prepare error: ' . mysqli_error($koneksi)]);
    exit;
}

mysqli_stmt_bind_param($stmt, 'ssi', $name, $option, $member);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan: ' . mysqli_stmt_error($stmt)]);
}

mysqli_stmt_close($stmt);