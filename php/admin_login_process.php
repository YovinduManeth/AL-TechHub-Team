<?php

session_start();

require_once "db.php";

// Allow POST requests only
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../admin-login.html");
    exit();
}

// Get submitted values
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

// Check empty fields
if (empty($username) || empty($password)) {
    header("Location: ../admin-login.html?error=empty");
    exit();
}

// Check minimum password length
if (strlen($password) < 8) {
    header("Location: ../admin-login.html?error=short_password");
    exit();
}

// Find administrator by username or email
$sql = "SELECT user_id, full_name, username, email, password, role
        FROM users
        WHERE username = ? OR email = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param("ss", $username, $username);

$stmt->execute();

$result = $stmt->get_result();

// Check whether account exists
if ($result->num_rows === 0) {
    $stmt->close();

    header("Location: ../admin-login.html?error=invalid");
    exit();
}

$user = $result->fetch_assoc();

$stmt->close();

// Verify password
if (!password_verify($password, $user["password"])) {
    header("Location: ../admin-login.html?error=invalid");
    exit();
}

// Verify administrator role
if ($user["role"] !== "admin") {
    header("Location: ../admin-login.html?error=unauthorized");
    exit();
}

// Regenerate session ID after successful authentication
session_regenerate_id(true);

// Store administrator session information
$_SESSION["user_id"] = $user["user_id"];
$_SESSION["full_name"] = $user["full_name"];
$_SESSION["username"] = $user["username"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];

// Remember Me functionality
if (isset($_POST["remember_me"])) {

    $remember_token = bin2hex(random_bytes(32));

    $update_sql = "UPDATE users
                   SET remember_token = ?
                   WHERE user_id = ?";

    $update_stmt = $conn->prepare($update_sql);

    if (!$update_stmt) {
        die("Remember Me database error: " . $conn->error);
    }

    $update_stmt->bind_param(
        "si",
        $remember_token,
        $user["user_id"]
    );

    if (!$update_stmt->execute()) {
        die("Remember Me update error: " . $update_stmt->error);
    }

    $update_stmt->close();

    setcookie("remember_token", $remember_token, [
        "expires" => time() + (30 * 24 * 60 * 60),
        "path" => "/",
        "secure" => false,
        "httponly" => true,
        "samesite" => "Lax"
    ]);
}

// Redirect to administrator dashboard
header("Location: ../admin-upload.php");
exit();

?>
