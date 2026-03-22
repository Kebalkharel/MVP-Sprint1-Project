<?php
require 'auth.php';
include 'db.php';

$user_id = $_SESSION["user_id"];

/* get logged-in student details */
$stmt = $mysqli->prepare("SELECT name, email, points FROM students WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

include 'header.php';
?>

<div class="hero">
    <h1>Welcome to Live Campus Hub</h1>
    <p>Your central platform for campus events, transport, clubs, library services, and student rewards.</p>
</div>

<div class="dashboard">

    <div class="card profile-card">
        <h3>Student Profile</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user["name"]); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
    </div>

    <div class="card reward-card">
        <h3>Reward Points</h3>
        <p style="font-size:28px;"><?php echo htmlspecialchars($user["points"]); ?> pts</p>
        <p>Earn points by attending campus events and activities.</p>
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
        <h3>Events</h3>
        <p>Check latest campus events and activities.</p>
        <a href="events.php">View Events</a>
    </div>

    <div class="card">
        <h3>Transport</h3>
        <p>See bus schedules and campus transport updates.</p>
        <a href="transport.php">View Transport</a>
    </div>

    <div class="card">
        <h3>Clubs</h3>
        <p>Connect with student clubs and societies.</p>
        <a href="clubs.php">View Clubs</a>
    </div>

    <div class="card">
        <h3>Library</h3>
        <p>Access library timings and resources.</p>
        <a href="library.php">View Library</a>
    </div>

    <div class="card">
        <h3>Rewards</h3>
        <p>Track your points and student engagement rewards.</p>
        <a href="rewards.php">View Rewards</a>
    </div>
</div>

<?php include 'footer.php'; ?>
