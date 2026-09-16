<?php

session_start();

require_once "db.php";


// ==========================================
// ONLY ALLOW POST REQUESTS
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../admin-login.html");
    exit();

}


// ==========================================
// GET LOGIN DATA
// ==========================================

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";


// ==========================================
// BASIC VALIDATION
// ==========================================

if (empty($username) || empty($password)) {

    header("Location: ../admin-login.html?error=empty");
    exit();

}


// ==========================================
// FIND USER
// ==========================================

$sql = "SELECT user_id, full_name, username, email, password, role
        FROM users
        WHERE username = ? OR email = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ss",
    $username,
    $username
);

$stmt->execute();

$result = $stmt->get_result();


// ==========================================
// CHECK USER
// ==========================================

if ($result->num_rows === 0) {

    $stmt->close();

    header("Location: ../admin-login.html?error=invalid");
    exit();

}


$user = $result->fetch_assoc();

$stmt->close();


// ==========================================
// CHECK PASSWORD
// ==========================================

if (!password_verify($password, $user["password"])) {

    header("Location: ../admin-login.html?error=invalid");
    exit();

}


// ==========================================
// CHECK ADMIN ROLE
// ==========================================

if ($user["role"] !== "admin") {

    header("Location: ../admin-login.html?error=unauthorized");
    exit();

}


// ==========================================
// LOGIN SUCCESS
// ==========================================

$_SESSION["user_id"] = $user["user_id"];
$_SESSION["full_name"] = $user["full_name"];
$_SESSION["username"] = $user["username"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];


// ==========================================
// REDIRECT TO ADMIN AREA
// ==========================================

header("Location: ../admin-upload.php");
exit();

?>