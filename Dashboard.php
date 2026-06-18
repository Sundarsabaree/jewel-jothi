<?php
// ============================================================
//  dashboard.php — Protected Page (Login Required)
// ============================================================
require_once 'config.php';

// Redirect to login if not logged in


$first_name = htmlspecialchars($_SESSION['first_name']);
$last_name  = htmlspecialchars($_SESSION['last_name']);
$email      = htmlspecialchars($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Jewel Jothi Tech</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', system-ui, sans-serif;
      background: #0a0a0a;
      color: #fff;
      min-height: 100vh;
    }

    /* NAV */
    nav {
      background: #111;
      border-bottom: 1px solid rgba(245,197,24,0.2);
      padding: 0 2rem;
      height: 64px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .nav-logo {
      font-size: 1.3rem;
      font-weight: 800;
      color: #F5C518;
    }

    .nav-right {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .nav-user {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      font-size: 0.9rem;
      color: #ccc;
    }

    .avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: rgba(245,197,24,0.15);
      border: 1.5px solid #F5C518;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      font-weight: 700;
      color: #F5C518;
    }

    .btn-logout {
      padding: 0.45rem 1.1rem;
      background: transparent;
      border: 1.5px solid rgba(245,197,24,0.4);
      border-radius: 6px;
      color: #F5C518;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.2s;
    }

    .btn-logout:hover { background: rgba(245,197,24,0.08); }

    /* MAIN */
    main {
      max-width: 960px;
      margin: 0 auto;
      padding: 3rem 2rem;
    }

    .welcome-card {
      background: #111;
      border: 1px solid rgba(245,197,24,0.2);
      border-radius: 16px;
      padding: 2.5rem;
      text-align: center;
      margin-bottom: 2rem;
    }

    .welcome-card h1 {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
    }

    .welcome-card h1 span { color: #F5C518; }
    .welcome-card p { color: #888; font-size: 0.95rem; }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
    }

    .info-card {
      background: #111;
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 12px;
      padding: 1.5rem;
    }

    .info-card .label {
      font-size: 0.78rem;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      margin-bottom: 0.4rem;
    }

    .info-card .value {
      font-size: 1rem;
      font-weight: 600;
      color: #fff;
    }
  </style>
</head>
<body>

<nav>
  <span class="nav-logo">Jewel Jothi Tech</span>
  <div class="nav-right">
    <div class="nav-user">
      <div class="avatar">
        <?= strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1)) ?>
      </div>
      <span><?= $first_name . ' ' . $last_name ?></span>
    </div>
    <a href="logout.php" class="btn-logout">Logout</a>
  </div>
</nav>

<main>
  <div class="welcome-card">
    <h1>Welcome, <span><?= $first_name ?>!</span></h1>
    <p>You are successfully logged into Jewel Jothi Tech dashboard.</p>
  </div>

  <div class="info-grid">
    <div class="info-card">
      <div class="label">First Name</div>
      <div class="value"><?= $first_name ?></div>
    </div>
    <div class="info-card">
      <div class="label">Last Name</div>
      <div class="value"><?= $last_name ?></div>
    </div>
    <div class="info-card">
      <div class="label">Email Address</div>
      <div class="value"><?= $email ?></div>
    </div>
    <div class="info-card">
      <div class="label">Session Status</div>
      <div class="value" style="color:#28c76f;">&#10004; Active</div>
    </div>
  </div>
</main>

</body>
</html>