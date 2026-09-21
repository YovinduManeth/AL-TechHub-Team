<?php

session_start();

require_once "db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../admin-login.html");
    exit();

}


$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";


if (empty($username) || empty($password)) {

    header("Location: ../admin-login.html?error=empty");
    exit();

}


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


if ($result->num_rows === 0) {

    $stmt->close();

    header("Location: ../admin-login.html?error=invalid");
    exit();

}


$user = $result->fetch_assoc();

$stmt->close();


if (!password_verify($password, $user["password"])) {

    header("Location: ../admin-login.html?error=invalid");
    exit();

}


if ($user["role"] !== "admin") {

    header("Location: ../admin-login.html?error=unauthorized");
    exit();

}


$_SESSION["user_id"] = $user["user_id"];
$_SESSION["full_name"] = $user["full_name"];
$_SESSION["username"] = $user["username"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];


header("Location: ../admin-upload.php");
exit();

?>