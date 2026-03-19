<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$timeout = 900; // 15 minutes

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION["LAST_ACTIVITY"]) && (time() - $_SESSION["LAST_ACTIVITY"] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$_SESSION["LAST_ACTIVITY"] = time();

if (isset($_SESSION["user_agent"]) && $_SESSION["user_agent"] !== $_SERVER["HTTP_USER_AGENT"]) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>