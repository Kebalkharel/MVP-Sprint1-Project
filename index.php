<?php
require 'auth.php';
include 'db.php';

$user_id = $_SESSION["user_id"];

/* Get logged-in student */
$stmt = $mysqli->prepare("SELECT name, email, points FROM students WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

/* Count event registrations */
$event_stmt = $mysqli->prepare("
    SELECT COUNT(*) AS total
    FROM event_registrations
    WHERE student_id = ?
");
$event_stmt->bind_param("i", $user_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result()->fetch_assoc();
$event_count = $event_result['total'] ?? 0;

/* Count joined clubs */
$club_stmt = $mysqli->prepare("
    SELECT COUNT(*) AS total
    FROM club_members
    WHERE student_id = ?
");
$club_stmt->bind_param("i", $user_id);
$club_stmt->execute();
$club_result = $club_stmt->get_result()->fetch_assoc();
$club_count = $club_result['total'] ?? 0;

/* Count purchases */
$purchase_stmt = $mysqli->prepare("
    SELECT COUNT(*) AS total
    FROM purchases
    WHERE user_id = ?
");
$purchase_stmt->bind_param("i", $user_id);
$purchase_stmt->execute();
$purchase_result = $purchase_stmt->get_result()->fetch_assoc();
$purchase_count = $purchase_result['total'] ?? 0;

include 'header.php';
?>

<div class="container">

    <div class="hero">
        <div class="hero-content">
            <h1>Welcome to Live Campus Hub</h1>
            <p>
                Your University of Wolverhampton student platform for campus events,
                transport, clubs, library services, rewards and cultural shop features.
            </p>
        </div>

        <div class="hero-logo">
            <img src="wlv-logo.jpg" alt="University of Wolverhampton Logo">
        </div>
    </div>

    <div class="stats">

        <div class="stat-box">
            <h3>Reward Points</h3>
            <p class="big-points"><?php echo htmlspecialchars($user["points"]); ?></p>
        </div>

        <div class="stat-box">
            <h3>Events Joined</h3>
            <p class="big-points"><?php echo htmlspecialchars($event_count); ?></p>
        </div>

        <div class="stat-box">
            <h3>Clubs Joined</h3>
            <p class="big-points"><?php echo htmlspecialchars($club_count); ?></p>
        </div>

        <div class="stat-box">
            <h3>Purchases</h3>
            <p class="big-points"><?php echo htmlspecialchars($purchase_count); ?></p>
        </div>

    </div>

    <div class="search-box">
        <form method="GET" action="search.php">
            <input type="text" name="search" placeholder="Search campus updates...">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="cards">

        <div class="card">
            <div class="icon">📅</div>
            <h3>Events</h3>
            <p>Register for campus events and earn reward points.</p>
            <a href="events.php">Open</a>
        </div>

        <div class="card">
            <div class="icon">🚌</div>
            <h3>Transport</h3>
            <p>View live transport updates and open routes in Google Maps.</p>
            <a href="transport.php">Open</a>
        </div>

        <div class="card">
            <div class="icon">👥</div>
            <h3>Clubs</h3>
            <p>Join student clubs and societies to earn points.</p>
            <a href="clubs.php">Open</a>
        </div>

        <div class="card">
            <div class="icon">📚</div>
            <h3>Library</h3>
            <p>Book library services and access academic support.</p>
            <a href="library.php">Open</a>
        </div>

        <div class="card">
            <div class="icon">🏆</div>
            <h3>Rewards</h3>
            <p>Track reward points, levels and reward transactions.</p>
            <a href="rewards.php">Open</a>
        </div>

        <div class="card">
            <div class="icon">🛍️</div>
            <h3>Cultural Shop</h3>
            <p>Spend your reward points on cultural shop items.</p>
            <a href="shop.php">Open</a>
        </div>

        <div class="card">
            <div class="icon">🧾</div>
            <h3>Purchase History</h3>
            <p>View your purchased items and points spent.</p>
            <a href="history.php">Open</a>
        </div>

        <div class="card">
            <div class="icon">⚙️</div>
            <h3>Admin Shop</h3>
            <p>Add, edit and delete cultural shop items.</p>
            <a href="admin-shop.php">Open</a>
        </div>

    </div>

</div>

<?php include 'footer.php'; ?>
