<?php
require 'auth.php';
include 'db.php';

$user_id = $_SESSION['user_id'];

$message = "";
$error = "";

/* Create club_members table automatically */
$mysqli->query("
CREATE TABLE IF NOT EXISTS club_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    club_name VARCHAR(255) NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
");

/* Join club */
if (isset($_POST['join_club'])) {

    $club_name = trim($_POST['club_name']);

    /* Check duplicate */
    $check = $mysqli->prepare("
        SELECT id FROM club_members
        WHERE student_id = ? AND club_name = ?
    ");

    $check->bind_param("is", $user_id, $club_name);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {

        $error = "You already joined this club.";

    } else {

        /* Insert club membership */
        $insert = $mysqli->prepare("
            INSERT INTO club_members (student_id, club_name)
            VALUES (?, ?)
        ");

        $insert->bind_param("is", $user_id, $club_name);
        $insert->execute();

        /* Get current points */
        $stmt = $mysqli->prepare("
            SELECT points FROM students WHERE id = ?
        ");

        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $student = $stmt->get_result()->fetch_assoc();

        $current_points = $student['points'] ?? 0;

        $new_points = $current_points + 20;

        /* Update student points */
        $update = $mysqli->prepare("
            UPDATE students SET points = ?
            WHERE id = ?
        ");

        $update->bind_param("ii", $new_points, $user_id);
        $update->execute();

        /* Add reward transaction */
        $description = "Joined club: " . $club_name;

        $reward = $mysqli->prepare("
            INSERT INTO reward_transactions
            (student_id, transaction_type, points, description)
            VALUES (?, 'Earned', 20, ?)
        ");

        $reward->bind_param("is", $user_id, $description);
        $reward->execute();

        $message = "Successfully joined " . $club_name . ". 20 reward points added.";
    }
}

include 'header.php';
?>

<div class="container">

    <h1 class="page-title">Student Clubs & Societies</h1>

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

        <!-- CLUB 1 -->
        <div class="card">

            <div class="icon">💻</div>

            <h3>Computer Science Society</h3>

            <p>
                Join coding competitions, workshops, and software development activities.
            </p>

            <p><strong>Reward:</strong> 20 points</p>

            <form method="POST">

                <input type="hidden"
                       name="club_name"
                       value="Computer Science Society">

                <button type="submit"
                        name="join_club"
                        class="btn-primary">
                    Join Club
                </button>

            </form>

        </div>

        <!-- CLUB 2 -->
        <div class="card">

            <div class="icon">⚽</div>

            <h3>Sports Club</h3>

            <p>
                Participate in football, basketball, cricket, and fitness events.
            </p>

            <p><strong>Reward:</strong> 20 points</p>

            <form method="POST">

                <input type="hidden"
                       name="club_name"
                       value="Sports Club">

                <button type="submit"
                        name="join_club"
                        class="btn-primary">
                    Join Club
                </button>

            </form>

        </div>

        <!-- CLUB 3 -->
        <div class="card">

            <div class="icon">🌍</div>

            <h3>International Students Club</h3>

            <p>
                Celebrate multicultural activities and connect with international students.
            </p>

            <p><strong>Reward:</strong> 20 points</p>

            <form method="POST">

                <input type="hidden"
                       name="club_name"
                       value="International Students Club">

                <button type="submit"
                        name="join_club"
                        class="btn-primary">
                    Join Club
                </button>

            </form>

        </div>

        <!-- CLUB 4 -->
        <div class="card">

            <div class="icon">🎨</div>

            <h3>Arts & Music Society</h3>

            <p>
                Explore music, painting, dance, photography and creative activities.
            </p>

            <p><strong>Reward:</strong> 20 points</p>

            <form method="POST">

                <input type="hidden"
                       name="club_name"
                       value="Arts & Music Society">

                <button type="submit"
                        name="join_club"
                        class="btn-primary">
                    Join Club
                </button>

            </form>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>