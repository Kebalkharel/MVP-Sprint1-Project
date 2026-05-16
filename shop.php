<?php
require 'auth.php';
include 'db.php';

$user_id = $_SESSION['user_id'] ?? 1;
$message = "";

/* Get user points */
$stmt = $mysqli->prepare("SELECT points FROM students WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

$points = $user['points'] ?? 0;

/* Handle buy */
if (isset($_POST['buy'])) {
    $item_id = intval($_POST['item_id']);

    $stmt = $mysqli->prepare("SELECT points_cost FROM shop_items WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();

    if ($item && $points >= $item['points_cost']) {
        $new_points = $points - $item['points_cost'];

        $update = $mysqli->prepare("UPDATE students SET points = ? WHERE id = ?");
		$update->bind_param("ii", $new_points, $user_id);
		$update->execute();

/* Save purchase history */
		$history = $mysqli->prepare("INSERT INTO purchases (user_id, item_id) VALUES (?, ?)");
		$history->bind_param("ii", $user_id, $item_id);
		$history->execute();

		$points = $new_points;
		$message = "Item purchased successfully!";
    } else {
        $message = "Not enough points.";
    }
}

/* Fetch items */
$items = $mysqli->query("SELECT * FROM shop_items");

include 'header.php';
?>

<div class="container">

    <h1 class="page-title">University Cultural Shop</h1>

    <?php if ($message != "") { ?>
        <div class="success-message">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php } ?>

    <p><strong>Your Points:</strong> <?php echo htmlspecialchars($points); ?></p>

    <div class="cards">

        <?php while ($row = $items->fetch_assoc()) { ?>
            <div class="card">

                <!-- IMAGE (IMPORTANT FIX) -->
                <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                     class="shop-img" 
                     alt="<?php echo htmlspecialchars($row['name']); ?>">

                <h3><?php echo htmlspecialchars($row['name']); ?></h3>

                <p><?php echo htmlspecialchars($row['description']); ?></p>

                <p>
                    <strong>Cost:</strong>
                    <?php echo htmlspecialchars($row['points_cost']); ?> points
                </p>

                <form method="POST">
                    <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">

                    <button type="submit" name="buy" class="btn-primary"
                        <?php if ($points < $row['points_cost']) echo "disabled"; ?>>
                        Buy Item
                    </button>
                </form>

            </div>
        <?php } ?>

    </div>

</div>

<?php include 'footer.php'; ?>