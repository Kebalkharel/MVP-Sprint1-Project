<?php
require 'auth.php';
include 'db.php';

$user_id = $_SESSION['user_id'] ?? 1;
$message = "";
$error = "";

/* Get student */
$stmt = $mysqli->prepare("SELECT name, points FROM students WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$name = $user['name'] ?? "Student";
$points = $user['points'] ?? 0;

/* Claim reward */
if (isset($_POST['claim_reward'])) {
    if ($points >= 100) {
        $new_points = $points - 100;

        $update = $mysqli->prepare("UPDATE students SET points = ? WHERE id = ?");
        $update->bind_param("ii", $new_points, $user_id);
        $update->execute();

        $insert = $mysqli->prepare("
            INSERT INTO reward_transactions 
            (student_id, transaction_type, points, description) 
            VALUES (?, 'Spent', 100, 'Claimed Free Coffee Voucher')
        ");
        $insert->bind_param("i", $user_id);
        $insert->execute();

        $points = $new_points;
        $message = "Reward claimed successfully. 100 points deducted.";
    } else {
        $error = "You do not have enough points to claim this reward.";
    }
}

/* Add points demo */
if (isset($_POST['earn_points'])) {
    $new_points = $points + 20;

    $update = $mysqli->prepare("UPDATE students SET points = ? WHERE id = ?");
    $update->bind_param("ii", $new_points, $user_id);
    $update->execute();

    $insert = $mysqli->prepare("
        INSERT INTO reward_transactions 
        (student_id, transaction_type, points, description) 
        VALUES (?, 'Earned', 20, 'Attended Campus Activity')
    ");
    $insert->bind_param("i", $user_id);
    $insert->execute();

    $points = $new_points;
    $message = "20 points added for campus activity.";
}

/* Level */
if ($points >= 200) {
    $level = "Gold";
    $progress = 100;
} elseif ($points >= 100) {
    $level = "Silver";
    $progress = 65;
} else {
    $level = "Bronze";
    $progress = 35;
}

/* Recent transactions */
$history = $mysqli->prepare("
    SELECT transaction_type, points, description, created_at
    FROM reward_transactions
    WHERE student_id = ?
    ORDER BY created_at DESC
    LIMIT 5
");
$history->bind_param("i", $user_id);
$history->execute();
$history_result = $history->get_result();

include 'header.php';
?>

<div class="container">

    <h1 class="page-title">Student Rewards</h1>

    <?php if ($message != "") { ?>
        <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>

    <?php if ($error != "") { ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php } ?>

    <div class="cards">

        <div class="card">
            <h3>Your Rewards Profile</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Total Points:</strong> <?php echo htmlspecialchars($points); ?></p>
            <p><strong>Level:</strong> <?php echo htmlspecialchars($level); ?></p>

            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo $progress; ?>%;"></div>
            </div>

            <p>Earn points by attending events, joining clubs and using campus services.</p>
        </div>

        <div class="card">
            <h3>Earn Points</h3>
            <p>Simulate attending a campus activity and earn 20 points.</p>

            <form method="POST">
                <button type="submit" name="earn_points" class="btn-primary">
                    Add 20 Points
                </button>
            </form>
        </div>

        <div class="card">
            <h3>Free Coffee Voucher</h3>
            <p><strong>Cost:</strong> 100 points</p>
            <p>Use your points to claim a free coffee voucher on campus.</p>

            <form method="POST">
                <button type="submit" name="claim_reward" class="btn-primary"
                    <?php if ($points < 100) echo "disabled"; ?>>
                    Claim Reward
                </button>
            </form>
        </div>

    </div>

    <h2 class="page-title" style="margin-top:35px;">Recent Reward Activity</h2>

    <table class="history-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Points</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($history_result->num_rows > 0) { ?>
                <?php while ($row = $history_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['transaction_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['points']); ?> points</td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">No reward activity yet.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

<?php include 'footer.php'; ?>
