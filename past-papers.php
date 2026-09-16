<?php

session_start();

require_once "php/db.php";


// ==========================================
// CHECK LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}


// ==========================================
// GET LOGGED-IN STUDENT
// ==========================================

$full_name = $_SESSION["full_name"];


// ==========================================
// GET SUBJECT AND GRADE
// ==========================================

$subject_id = $_GET["subject"] ?? "";


// Make sure subject ID is valid

if (!is_numeric($subject_id)) {

    header("Location: dashboard.php");
    exit();

}

$subject_id = (int)$subject_id;

// ==========================================
// GET SUBJECT DETAILS
// ==========================================

$sql = "SELECT
            subject_id,
            subject_code,
            subject_name
        FROM subjects
        WHERE subject_id = ?";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $subject_id);

$stmt->execute();

$result = $stmt->get_result();

$subject = $result->fetch_assoc();

$stmt->close();

// ==========================================
// CHECK SUBJECT EXISTS
// ==========================================

if (!$subject) {

    header("Location: dashboard.php");
    exit();

}


// ==========================================
// GET PAST PAPERS
// ==========================================

$sql = "SELECT
            paper_id,
            grade,
            year,
            title,
            file_path,
            created_at
        FROM past_papers
        WHERE subject_id = ?
        ORDER BY year DESC";


$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $subject_id
);

$stmt->execute();

$result = $stmt->get_result();

$papers = [];

while ($row = $result->fetch_assoc()) {

    $papers[] = $row;

}

$stmt->close();

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Past Papers |
        <?php echo htmlspecialchars($subject["subject_code"]); ?>
        |
        A/L TechHub
    </title>


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

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body>