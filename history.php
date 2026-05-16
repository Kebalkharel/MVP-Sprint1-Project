<?php
require 'auth.php';
include 'db.php';

$user_id = $_SESSION['user_id'] ?? 1;

$query = $mysqli->prepare("
    SELECT 
        shop_items.name,
        shop_items.image,
        shop_items.points_cost,
        purchases.purchased_at
    FROM purchases
    JOIN shop_items ON purchases.item_id = shop_items.id
    WHERE purchases.user_id = ?
    ORDER BY purchases.purchased_at DESC
");

$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

include 'header.php';
?>

<div class="container">
    <h1 class="page-title">Purchase History</h1>

    <table class="history-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Item</th>
                <th>Points Used</th>
                <th>Purchased At</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                             class="history-img" 
                             alt="<?php echo htmlspecialchars($row['name']); ?>">
                    </td>

                    <td><?php echo htmlspecialchars($row['name']); ?></td>

                    <td><?php echo htmlspecialchars($row['points_cost']); ?> points</td>

                    <td><?php echo htmlspecialchars($row['purchased_at']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>