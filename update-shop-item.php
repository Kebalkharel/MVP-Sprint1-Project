<?php
require 'auth.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = intval($_POST["id"]);
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $points_cost = intval($_POST["points_cost"]);
    $image = trim($_POST["image"]);

    $stmt = $mysqli->prepare(
        "UPDATE shop_items SET name=?, description=?, points_cost=?, image=? WHERE id=?"
    );

    $stmt->bind_param("ssisi", $name, $description, $points_cost, $image, $id);
    $stmt->execute();
}

header("Location: admin-shop.php?updated=1");
exit();
?>