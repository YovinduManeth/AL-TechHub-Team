<?php

session_start();

require_once "db.php";

// ==========================================
// ONLY ALLOW POST REQUESTS
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../login.html");
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

    header("Location: ../login.html?error=empty");
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

    header("Location: ../login.html?error=invalid");
    exit();

}


$user = $result->fetch_assoc();

$stmt->close();
