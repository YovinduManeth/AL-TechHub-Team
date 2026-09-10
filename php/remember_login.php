<?php


require_once "db.php";


// ==========================================
// ALREADY LOGGED IN
// ==========================================

if (isset($_SESSION["user_id"])) {

    return;

}


// ==========================================
// CHECK REMEMBER COOKIE
// ==========================================

if (!isset($_COOKIE["remember_token"])) {

    return;

}


$remember_token =
    $_COOKIE["remember_token"];


// ==========================================
// FIND USER
// ==========================================

$sql =
    "SELECT
        user_id,
        full_name,
        username,
        email,
        role
     FROM users
     WHERE remember_token = ?
     LIMIT 1";

$stmt =
    $conn->prepare($sql);

$stmt->bind_param(
    "s",
    $remember_token
);

$stmt->execute();

$result =
    $stmt->get_result();

