<?php

session_start();

require_once "db.php";


// Check administrator session

if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: ../admin-login.html?error=unauthorized");
    exit();
}


// Allow POST requests only

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../admin-change-password.php");
    exit();

}


// Check CSRF token

$csrf_token = $_POST["csrf_token"] ?? "";

if (
    empty($_SESSION["csrf_token"]) ||
    !hash_equals($_SESSION["csrf_token"], $csrf_token)
) {
    die("Invalid request. Please return to the password change page.");
}


// Get form values

$current_password = $_POST["current_password"] ?? "";
$new_password = $_POST["new_password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";


// Check empty fields

if (
    empty($current_password) ||
    empty($new_password) ||
    empty($confirm_password)
) {

    header("Location: ../admin-change-password.php?error=empty");
    exit();

}


// Check minimum password length

if (strlen($new_password) < 8) {

    header("Location: ../admin-change-password.php?error=length");
    exit();

}


// Check password confirmation

if ($new_password !== $confirm_password) {

    header("Location: ../admin-change-password.php?error=match");
    exit();

}


// Get current administrator password

$user_id = $_SESSION["user_id"];

$sql = "SELECT password, role
        FROM users
        WHERE user_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

$stmt->close();


// Verify administrator account

if (!$user || $user["role"] !== "admin") {

    session_unset();
    session_destroy();

    header("Location: ../admin-login.html?error=unauthorized");
    exit();

}


// Verify current password

if (!password_verify($current_password, $user["password"])) {

    header("Location: ../admin-change-password.php?error=current");
    exit();

}


// Hash new password

$hashed_password = password_hash(
    $new_password,
    PASSWORD_DEFAULT
);


// Update database

$update_sql = "UPDATE users
               SET password = ?
               WHERE user_id = ?";

$update_stmt = $conn->prepare($update_sql);

$update_stmt->bind_param(
    "si",
    $hashed_password,
    $user_id
);


if ($update_stmt->execute()) {

    // Generate a new CSRF token

    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

    $update_stmt->close();

    header("Location: ../admin-change-password.php?success=1");
    exit();

} else {

    $update_stmt->close();

    header("Location: ../admin-change-password.php?error=failed");
    exit();

}

?>