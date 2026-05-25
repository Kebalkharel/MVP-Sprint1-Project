<?php
require 'auth.php';
include 'db.php';

$user_id = $_SESSION['user_id'];
$message = "";
$error = "";

/* Register Event + Add 20 Points */
if (isset($_POST['register'])) {

    $event_name = trim($_POST['event_name']);

    /* Check duplicate registration */
    $check = $mysqli->prepare("
        SELECT id FROM event_registrations
        WHERE student_id = ? AND event_name = ?
    ");
    $check->bind_param("is", $user_id, $event_name);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $error = "You have already registered for this event.";
    } else {

        /* Insert event registration */
        $insert = $mysqli->prepare("
            INSERT INTO event_registrations (student_id, event_name)
            VALUES (?, ?)
        ");
        $insert->bind_param("is", $user_id, $event_name);
        $insert->execute();

        /* Get current points */
        $stmt = $mysqli->prepare("SELECT points FROM students WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $student = $stmt->get_result()->fetch_assoc();

        $current_points = $student['points'] ?? 0;
        $new_points = $current_points + 20;

        /* Update student points */
        $update = $mysqli->prepare("UPDATE students SET points = ? WHERE id = ?");
        $update->bind_param("ii", $new_points, $user_id);
        $update->execute();

        /* Add reward transaction */
        $description = "Registered for event: " . $event_name;

        $reward = $mysqli->prepare("
            INSERT INTO reward_transactions
            (student_id, transaction_type, points, description)
            VALUES (?, 'Earned', 20, ?)
        ");
        $reward->bind_param("is", $user_id, $description);
        $reward->execute();

        $message = "Successfully registered for " . $event_name . ". 20 reward points added.";
    }
}

include 'header.php';
?>

<div class="container">

    <h1 class="page-title">Campus Events</h1>

    <?php if ($message != "") { ?>
        <div class="success-message">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php } ?>

    <?php if ($error != "") { ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <div class="cards">

        <div class="card">
            <div class="icon">🎓</div>
            <h3>Freshers Welcome Event</h3>
            <p>Meet new students, explore campus life, and learn about university support services.</p>
            <p><strong>Date:</strong> 20 May 2026</p>
            <p><strong>Reward:</strong> 20 points</p>

            <form method="POST">
                <input type="hidden" name="event_name" value="Freshers Welcome Event">
                <button type="submit" name="register" class="btn-primary">
                    Register
                </button>
            </form>
        </div>

        <div class="card">
            <div class="icon">💻</div>
            <h3>AI & Technology Workshop</h3>
            <p>Learn about modern AI tools, software development, and digital innovation.</p>
            <p><strong>Date:</strong> 28 May 2026</p>
            <p><strong>Reward:</strong> 20 points</p>

            <form method="POST">
                <input type="hidden" name="event_name" value="AI & Technology Workshop">
                <button type="submit" name="register" class="btn-primary">
                    Register
                </button>
            </form>
        </div>

        <div class="card">
            <div class="icon">⚽</div>
            <h3>Sports Competition</h3>
            <p>Join football, basketball, and indoor sports competitions with other students.</p>
            <p><strong>Date:</strong> 2 June 2026</p>
            <p><strong>Reward:</strong> 20 points</p>

            <form method="POST">
                <input type="hidden" name="event_name" value="Sports Competition">
                <button type="submit" name="register" class="btn-primary">
                    Register
                </button>
            </form>
        </div>

        <div class="card">
            <div class="icon">🌍</div>
            <h3>International Culture Day</h3>
            <p>Celebrate cultural diversity through food, clothing, music, and student performances.</p>
            <p><strong>Date:</strong> 10 June 2026</p>
            <p><strong>Reward:</strong> 20 points</p>

            <form method="POST">
                <input type="hidden" name="event_name" value="International Culture Day">
                <button type="submit" name="register" class="btn-primary">
                    Register
                </button>
            </form>
        </div>

    </div>

</div>

<?php include 'footer.php'; ?>