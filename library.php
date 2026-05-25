<?php
require 'auth.php';
include 'db.php';

$user_id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['book_room'])) {

    $stmt = $mysqli->prepare("SELECT points FROM students WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    $points = $user['points'];
    $new_points = $points + 20;

    $update = $mysqli->prepare("UPDATE students SET points = ? WHERE id = ?");
    $update->bind_param("ii", $new_points, $user_id);
    $update->execute();

    $description = "Booked library study room";

    $reward = $mysqli->prepare("
        INSERT INTO reward_transactions 
        (student_id, transaction_type, points, description)
        VALUES (?, 'Earned', 20, ?)
    ");
    $reward->bind_param("is", $user_id, $description);
    $reward->execute();

    $message = "Library room booked. 20 reward points added.";
}

include 'header.php';
?>

<div class="container">
    <h1 class="page-title">Library Services</h1>

    <?php if ($message != "") { ?>
        <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>

    <div class="cards">
        <div class="card">
            <h3>Study Room Booking</h3>
            <p>Book a study room and earn 20 reward points.</p>

            <form method="POST">
                <button type="submit" name="book_room" class="btn-primary">
                    Book Room
                </button>
            </form>
        </div>

        <div class="card">
            <h3>Library Opening Hours</h3>
            <p>Monday - Friday: 9:00 AM - 8:00 PM</p>
            <p>Saturday - Sunday: 10:00 AM - 5:00 PM</p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>