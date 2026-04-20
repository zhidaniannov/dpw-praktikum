<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../login.php');
  exit;
}
require_once '../koneksi.php';

$action = $_POST['action'] ?? '';

switch ($action) {

  // ── ADD ────────────────────────────────────────────
  case 'add':
    $name = mysqli_real_escape_string($koneksi, trim($_POST['name'] ?? ''));

    if ($name === '') {
      header('Location: dashboard.php?error=name_required');
      exit;
    }

    mysqli_query($koneksi, "INSERT INTO guests (name) VALUES ('$name')");
    header('Location: dashboard.php?saved=1');
    exit;

  // ── EDIT ───────────────────────────────────────────
  case 'edit':
    $id   = (int)($_POST['guest_id'] ?? 0);
    $name = mysqli_real_escape_string($koneksi, trim($_POST['name'] ?? ''));

    if ($id < 1 || $name === '') {
      header('Location: dashboard.php?error=invalid');
      exit;
    }

    mysqli_query($koneksi, "UPDATE guests SET name='$name' WHERE guest_id=$id");
    header('Location: dashboard.php?saved=1');
    exit;

  // ── DELETE ─────────────────────────────────────────
  case 'delete':
    $id = (int)($_POST['guest_id'] ?? 0);

    if ($id < 1) {
      header('Location: dashboard.php?error=invalid');
      exit;
    }

    mysqli_query($koneksi, "DELETE FROM guests WHERE guest_id=$id");
    header('Location: dashboard.php?deleted=1');
    exit;

  default:
    header('Location: dashboard.php');
    exit;
}