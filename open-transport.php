<?php
require 'auth.php';
include 'db.php';

$user_id = $_SESSION['user_id'];
$route_id = intval($_GET['id']);

$stmt = $mysqli->prepare("SELECT route_name, google_maps_link FROM transport_updates WHERE id = ?");
$stmt->bind_param("i", $route_id);
$stmt->execute();
$route = $stmt->get_result()->fetch_assoc();

if ($route) {
    $stmt = $mysqli->prepare("SELECT points FROM students WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    $points = $user['points'];
    $new_points = $points + 20;

    $update = $mysqli->prepare("UPDATE students SET points = ? WHERE id = ?");
    $update->bind_param("ii", $new_points, $user_id);
    $update->execute();

    $description = "Checked transport route: " . $route['route_name'];

    $reward = $mysqli->prepare("
        INSERT INTO reward_transactions 
        (student_id, transaction_type, points, description)
        VALUES (?, 'Earned', 20, ?)
    ");
    $reward->bind_param("is", $user_id, $description);
    $reward->execute();

    header("Location: " . $route['google_maps_link']);
    exit();
}

header("Location: transport.php");
exit();
?>