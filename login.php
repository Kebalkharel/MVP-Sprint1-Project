<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $mysqli->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];

            header("Location: index.php");
            exit();

        } else {
            $error = "Invalid password";
        }

    } else {
        $error = "Student account not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Live Campus Hub - Login</title>
    <link rel="stylesheet" href="style.css?v=10">
</head>

<body>

<div class="login-page">

    <div class="login-card">

        <img src="images/wlv-logo.jpg" class="login-logo">

        <h1>Live Campus Hub</h1>

        <p class="login-subtitle">
            University of Wolverhampton Student Platform
        </p>

        <?php if($error != "") { ?>
            <div class="error-box">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php } ?>

        <form method="POST">

            <input type="email"
                   name="email"
                   placeholder="Student Email"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Password"
                   required
                   minlength="6">

            <button type="submit">
                Login
            </button>

        </form>

        <div class="register-link">
            New student?
            <a href="register.php">Create Account</a>
        </div>

    </div>

</div>

</body>
</html>