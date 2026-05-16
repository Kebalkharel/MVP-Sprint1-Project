<?php
require 'auth.php';
include 'db.php';

$items = $mysqli->query("SELECT * FROM shop_items ORDER BY id DESC");

include 'header.php';
?>

<div class="container">

    <h1 class="page-title">Admin - Manage Cultural Shop</h1>

    <?php if (isset($_GET['success'])) { ?>
        <div class="success-message">Item added successfully.</div>
    <?php } ?>

    <?php if (isset($_GET['updated'])) { ?>
        <div class="success-message">Item updated successfully.</div>
    <?php } ?>

    <?php if (isset($_GET['deleted'])) { ?>
        <div class="success-message">Item deleted successfully.</div>
    <?php } ?>

    <div class="admin-card">
        <h3>Add New Shop Item</h3>

        <form method="POST" action="add-shop-item.php" class="admin-form">

            <input type="text" name="name" placeholder="Item name" required>

            <textarea name="description" placeholder="Item description" required></textarea>

            <input type="number" name="points_cost" placeholder="Points cost" required>

            <input type="text" name="image" placeholder="images/example.jpg" required>

            <button type="submit" class="btn-primary">Add Item</button>

        </form>
    </div>

    <table class="history-table admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Item</th>
                <th>Description</th>
                <th>Points</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $items->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($row['image']); ?>"
                             class="history-img"
                             alt="<?php echo htmlspecialchars($row['name']); ?>">
                    </td>

                    <td><?php echo htmlspecialchars($row['name']); ?></td>

                    <td><?php echo htmlspecialchars($row['description']); ?></td>

                    <td><?php echo htmlspecialchars($row['points_cost']); ?> points</td>

                    <td>
                        <a href="edit-shop-item.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                            Edit
                        </a>
                        |
                        <a class="delete-link"
                           href="delete-shop-item.php?id=<?php echo htmlspecialchars($row['id']); ?>"
                           onclick="return confirm('Are you sure you want to delete this item?');">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

<?php include 'footer.php'; ?>