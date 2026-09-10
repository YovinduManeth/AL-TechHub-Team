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

// ==========================================
// CHECK PASSWORD
// ==========================================

if (!password_verify($password, $user["password"])) {

    header("Location: ../login.html?error=invalid");
    exit();

}

// ==========================================
// REMEMBER ME
// ==========================================

if (isset($_POST["remember_me"])) {

    // Generate secure random token

    $remember_token =
        bin2hex(random_bytes(32));


    // Store token in database

    $update_sql =
        "UPDATE users
         SET remember_token = ?
         WHERE user_id = ?";

    $update_stmt =
        $conn->prepare($update_sql);

    $update_stmt->bind_param(
        "si",
        $remember_token,
        $user["user_id"]
    );

    $update_stmt->execute();

    $update_stmt->close();


    // Create cookie for 30 days

    setcookie(
        "remember_token",
        $remember_token,
        [
            "expires" => time() + (30 * 24 * 60 * 60),
            "path" => "/",
            "secure" => false,
            "httponly" => true,
            "samesite" => "Lax"
        ]
    );

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
// REDIRECT
// ==========================================

if ($user["role"] === "admin") {

    header("Location: ../admin-upload.php");

} else {

    header("Location: ../dashboard.php");

}

exit();

?>
