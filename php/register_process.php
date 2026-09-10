<?php

require_once "db.php";


// ==========================================
// ONLY ALLOW POST REQUESTS
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../register.html");
    exit();

}


// ==========================================
// GET FORM DATA
// ==========================================

$full_name = trim($_POST["full_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";

$basket02 = $_POST["basket02"] ?? "";
$basket03 = $_POST["basket03"] ?? "";

$terms = isset($_POST["terms"]);


// ==========================================
// BASIC VALIDATION
// ==========================================

if (
    empty($full_name) ||
    empty($email) ||
    empty($username) ||
    empty($password) ||
    empty($confirm_password) ||
    empty($basket02) ||
    empty($basket03)
) {

    die("Please fill in all required fields.");

}

if (!$terms) {

    die("You must agree to the Terms and Conditions.");

}

// ==========================================
// CHECK EMAIL
// ==========================================

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    die("Please enter a valid email address.");

}


// ==========================================
// CHECK PASSWORD
// ==========================================

if ($password !== $confirm_password) {

    die("Passwords do not match.");

}


if (strlen($password) < 8) {

    die("Password must contain at least 8 characters.");

}


// ==========================================
// CHECK EMAIL / USERNAME
// ==========================================

$check_sql = "SELECT user_id FROM users
              WHERE email = ? OR username = ?
              LIMIT 1";

$check_stmt = $conn->prepare($check_sql);

$check_stmt->bind_param(
    "ss",
    $email,
    $username
);

$check_stmt->execute();

$check_result = $check_stmt->get_result();


if ($check_result->num_rows > 0) {

    die("Email or username already exists.");

}

$check_stmt->close();