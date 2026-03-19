<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

$stmt = $mysqli->prepare("SELECT * FROM students WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

if (password_verify($password, $row["password"])) {

session_regenerate_id(true);

$_SESSION["user_id"] = $row["id"];
$_SESSION["user_name"] = $row["name"];
$_SESSION["user_email"] = $row["email"];

header("Location:index.php");
exit();

} else {

$error = "Incorrect password";

}

} else {

$error = "Student not found";

}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-page">
<div class="login-box">

<h1>Live Campus Hub</h1>
<p class="login-subtitle">Student Login</p>

<?php if(!empty($error)){ ?>
<p class="error-message"><?php echo $error; ?></p>
<?php } ?>

<form method="POST">

<label>Email</label>
<input type="email" name="email" placeholder="student@wlv.ac.uk" required>

<label>Password</label>
<input type="password" name="password" required>

<button type="submit">Login</button>

</form>

<p class="demo-text">
New student? <a href="register.php">Register</a>
</p>

</div>
</div>

</body>
</html>