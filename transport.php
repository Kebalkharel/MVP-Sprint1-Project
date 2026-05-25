<?php
require 'auth.php';
include 'db.php';

$updates = $mysqli->query("SELECT * FROM transport_updates ORDER BY updated_at DESC");

include 'header.php';
?>

<div class="container">

    <h1 class="page-title">Live Transport Updates</h1>

    <div class="cards">

        <?php while ($row = $updates->fetch_assoc()) { ?>
            <div class="card">

                <div class="icon">🚌</div>

                <h3><?php echo htmlspecialchars($row['route_name']); ?></h3>

                <p><strong>From:</strong> <?php echo htmlspecialchars($row['start_location']); ?></p>

                <p><strong>To:</strong> <?php echo htmlspecialchars($row['end_location']); ?></p>

                <p>
                    <strong>Status:</strong>
                    <span class="<?php echo ($row['status'] == 'On Time') ? 'status-green' : 'status-red'; ?>">
                        <?php echo htmlspecialchars($row['status']); ?>
                    </span>
                </p>

                <p><?php echo htmlspecialchars($row['update_message']); ?></p>

                <p><strong>Updated:</strong> <?php echo htmlspecialchars($row['updated_at']); ?></p>

                <a href="open-transport.php?id=<?php echo htmlspecialchars($row['id']); ?>" target="_blank">
                    Open in Google Maps + Earn 20 Points
                </a>

            </div>
        <?php } ?>

    </div>

</div>

<?php include 'footer.php'; ?>
