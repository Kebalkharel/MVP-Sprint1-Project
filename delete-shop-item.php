<?php
require 'auth.php';
include 'db.php';

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    $stmt = $mysqli->prepare("DELETE FROM shop_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: admin-shop.php");
exit();
?>