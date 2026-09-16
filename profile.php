<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION["user_id"];

$sql = "SELECT full_name, username, email, role
        FROM users
        WHERE user_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    session_destroy();
    header("Location: login.html");
    exit();
}

$user = $result->fetch_assoc();

$stmt->close();
$subject_sql = "SELECT s.subject_name
                FROM student_subjects ss
                INNER JOIN subjects s
                    ON ss.subject_id = s.subject_id
                WHERE ss.user_id = ?
                ORDER BY s.subject_id";

$subject_stmt = $conn->prepare($subject_sql);

$subject_stmt->bind_param("i", $user_id);

$subject_stmt->execute();

$subject_result = $subject_stmt->get_result();

$student_subjects = [];

while ($subject = $subject_result->fetch_assoc()) {
    $student_subjects[] = $subject["subject_name"];
}

$subject_stmt->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile | A/L TechHub</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>