<?php
require 'auth.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $points_cost = intval($_POST["points_cost"]);
    $image = trim($_POST["image"]);

    $stmt = $mysqli->prepare(
        "INSERT INTO shop_items (name, description, points_cost, image) VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("ssis", $name, $description, $points_cost, $image);
    $stmt->execute();
}

header("Location: admin-shop.php");
exit();
?>