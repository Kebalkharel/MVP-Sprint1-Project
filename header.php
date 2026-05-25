<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Campus Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="top-bar">

    <div class="left-header">
        <button class="menu-btn" type="button" onclick="toggleMenu()">☰</button>
    </div>

    <div class="center-header">
        <div class="logo-title">
            <img src="wlv-logo.jpg" class="header-logo" alt="University of Wolverhampton Logo">
            <h2>Live Campus Hub</h2>
        </div>
    </div>

    <div class="right-header">
        <div class="profile-dropdown">
            <button class="profile-btn" type="button" onclick="toggleProfile()">
                <?php echo htmlspecialchars($_SESSION['name'] ?? 'Student'); ?> ▼
            </button>

            <div id="profileMenu" class="dropdown-content">
                <a href="index.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>

</header>

<nav id="sideMenu" class="side-menu">
    <a href="index.php">Dashboard</a>
    <a href="events.php">Events</a>
    <a href="transport.php">Transport</a>
    <a href="clubs.php">Clubs</a>
    <a href="library.php">Library</a>
    <a href="shop.php">Cultural Shop</a>
    <a href="history.php">Purchase History</a>
    <a href="admin-shop.php">Admin Shop</a>
    <a href="requirements.php">Requirements</a>
    <a href="risk-register.php">Risk Register</a>
    <a href="rewards.php">Rewards</a>
    <a href="logout.php">Logout</a>
</nav>

<script src="script.js"></script>