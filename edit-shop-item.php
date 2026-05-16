<?php
require 'auth.php';
include 'db.php';

$id = intval($_GET['id']);

$stmt = $mysqli->prepare("SELECT * FROM shop_items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

include 'header.php';
?>

<div class="container">
    <h1 class="page-title">Edit Shop Item</h1>

    <div class="admin-card">
        <form method="POST" action="update-shop-item.php" class="admin-form">

            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">

            <input type="text" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>

            <textarea name="description" required><?php echo htmlspecialchars($item['description']); ?></textarea>

            <input type="number" name="points_cost" value="<?php echo $item['points_cost']; ?>" required>

            <input type="text" name="image" value="<?php echo htmlspecialchars($item['image']); ?>" required>

            <button type="submit" class="btn-primary">Update Item</button>

        </form>
    </div>
</div>

<?php include 'footer.php'; ?>