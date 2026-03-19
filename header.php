<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current = basename($_SERVER['PHP_SELF']);
$userName = isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "Profile";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Live Campus Hub</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header class="top-bar">

<div class="menu-section">
<button class="menu-btn" onclick="toggleMenu()">☰</button>
</div>

<div class="title-section">

<div class="title-wrapper">

<img src="wlv-logo.jpg" class="header-logo" alt="University of Wolverhampton Logo">

<h2>Live Campus Hub</h2>

</div>

</div>

<div class="profile-section">

<div class="profile-dropdown">

<button class="profile-btn" onclick="toggleProfile()">
<?php echo htmlspecialchars($userName); ?> ▼
</button>

<div class="dropdown-content" id="profileMenu">
<a href="index.php">Dashboard</a>
<a href="logout.php">Logout</a>
</div>

</div>

</div>

</header>

<nav class="side-menu" id="sideMenu">
<a href="index.php" class="<?= $current=='index.php'?'active':'' ?>">Home</a>
<a href="events.php">Events</a>
<a href="transport.php">Transport</a>
<a href="clubs.php">Clubs</a>
<a href="library.php">Library</a>
<a href="rewards.php">Rewards</a>
<a href="logout.php">Logout</a>
</nav>

<div class="container">
