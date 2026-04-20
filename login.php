<?php
session_start();
require_once 'koneksi.php';

$error = '';

// Redirect jika sudah login
if (isset($_SESSION['user'])) {
  header('Location: dashboard/dashboard.php');
  exit;
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $error = 'Username dan password wajib diisi.';
  } else {
    $stmt = mysqli_prepare($koneksi, "SELECT username, password FROM users WHERE username = ? LIMIT 1");

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $dbUser, $dbPass);

      if (mysqli_stmt_fetch($stmt)) {

        if (!empty($dbPass) && (password_verify($password, $dbPass) || $password === $dbPass)) {
          $_SESSION['user'] = $dbUser;

          mysqli_stmt_close($stmt);
          header('Location: dashboard/dashboard.php');
          exit;
        } else {
          $error = 'Kredensial salah.';
        }

      } else {
        $error = 'Kredensial salah.';
      }

      mysqli_stmt_close($stmt);

    } else {
      // fallback
      if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user'] = $username;
        header('Location: dashboard/dashboard.php');
        exit;
      } else {
        $error = 'Kredensial salah.';
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login — Wedding Admin</title>
  <link rel="stylesheet" href="/dashboard/style.css" />

  <style>
    /* 🔥 FIX CENTER DI SINI */
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 24px;
    }

    /* Background */
    .login-bg {
      position: fixed;
      inset: 0;
      z-index: 0;
      background:
        radial-gradient(ellipse 70% 60% at 25% 30%, rgba(201,148,58,0.13) 0%, transparent 70%),
        radial-gradient(ellipse 60% 50% at 75% 70%, rgba(196,168,130,0.15) 0%, transparent 65%),
        linear-gradient(160deg, #fdf6ec 0%, #f5e9d0 50%, #ede0c4 100%);
    }

    .login-bg-pattern {
      position: fixed;
      inset: 0;
      z-index: 0;
      background-image: radial-gradient(circle, rgba(201,148,58,0.06) 1px, transparent 1px);
      background-size: 32px 32px;
    }

    .login-wrap {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 440px;
      margin: 0 auto;
    }

    .login-card {
      background: rgba(255, 253, 248, 0.94);
      border: 1px solid rgba(201,148,58,0.22);
      border-radius: 28px;
      box-shadow: 0 24px 64px rgba(122,92,58,0.22);
      padding: 52px 44px 44px;
      backdrop-filter: blur(10px);
    }

    .login-logo-area {
      text-align: center;
      margin-bottom: 32px;
    }

    .login-title {
      font-size: 36px;
      color: #c9943a;
    }

    .form-group {
      margin-bottom: 16px;
    }

    .form-input {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid #ccc;
    }

    .login-btn-wrap {
      margin-top: 20px;
    }

    .btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 20px;
      background: #c9943a;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }

    .login-error {
      display: none;
      background: #fde8e8;
      color: #a93226;
      padding: 10px;
      border-radius: 10px;
      margin-bottom: 12px;
    }
  </style>
</head>

<body>

  <div class="login-bg"></div>
  <div class="login-bg-pattern"></div>

  <div class="login-wrap">
    <div class="login-card">

      <div class="login-logo-area">
        <div class="login-title">Wedding Admin</div>
      </div>

      <form method="post">

        <div class="login-error" <?php if ($error) echo 'style="display:block"'; ?>>
          <?php echo htmlspecialchars($error); ?>
        </div>

        <div class="form-group">
          <input class="form-input" type="text" name="username" placeholder="Username">
        </div>

        <div class="form-group">
          <input class="form-input" type="password" name="password" placeholder="Password">
        </div>

        <div class="login-btn-wrap">
          <button class="btn" type="submit">Enter Admin Panel</button>
        </div>

      </form>

    </div>
  </div>

</body>
</html>