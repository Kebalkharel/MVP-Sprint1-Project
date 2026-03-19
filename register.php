<?php
session_start();
include 'db.php';

$error = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

if (!preg_match("/@wlv\.ac\.uk$/", $email)) {
$error = "Only @wlv.ac.uk email allowed";
} else {

$stmt = $mysqli->prepare("SELECT id FROM students WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

$error = "Student already registered";

} else {

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("INSERT INTO students(name,email,password) VALUES(?,?,?)");
$stmt->bind_param("sss",$name,$email,$hashedPassword);

if ($stmt->execute()) {
$message = "Registration successful. Please login.";
} else {
$error = "Registration failed.";
}

}

}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-page">
<div class="login-box">

<h1>Student Registration</h1>

<?php if(!empty($error)){ ?>
<p class="error-message"><?php echo $error; ?></p>
<?php } ?>

<?php if(!empty($message)){ ?>
<p class="success-message"><?php echo $message; ?></p>
<?php } ?>

<form method="POST">

<label>Full Name</label>
<input type="text" name="name" required>

<label>University Email</label>
<input type="email" name="email" placeholder="student@wlv.ac.uk" required>

<label>Password</label>
<input type="password" name="password" required>

<button type="submit">Register</button>

</form>

<p class="demo-text">
Already have account? <a href="login.php">Login</a>
</p>

</div>
</div>

</body>
</html>