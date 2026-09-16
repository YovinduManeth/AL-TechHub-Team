<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";


// ==========================================
// CHECK LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html");
    exit();

}

$user_id = $_SESSION["user_id"];


// ==========================================
// GET CURRENT USER DATA
// ==========================================

$sql = "SELECT full_name, username, email
        FROM users
        WHERE user_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {

    $stmt->close();

    session_destroy();

    header("Location: login.html");
    exit();

}

$user = $result->fetch_assoc();

$stmt->close();