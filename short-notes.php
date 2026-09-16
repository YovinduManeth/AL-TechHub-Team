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
// GET UNIT ID
// ==========================================

$unit_id = $_GET["unit"] ?? "";


// Make sure unit ID is a number

if (!is_numeric($unit_id)) {

    header("Location: dashboard.php");
    exit();

}

$unit_id = (int)$unit_id;


// ==========================================
// GET UNIT DETAILS
// ==========================================

$sql = "SELECT
            units.unit_id,
            units.subject_id,
            units.grade,
            units.unit_number,
            units.unit_title,
            subjects.subject_code,
            subjects.subject_name

        FROM units

        INNER JOIN subjects
            ON units.subject_id = subjects.subject_id

        WHERE units.unit_id = ?";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $unit_id);

$stmt->execute();

$result = $stmt->get_result();

$unit = $result->fetch_assoc();

$stmt->close();

// ==========================================
// CHECK UNIT EXISTS
// ==========================================

if (!$unit) {

    header("Location: dashboard.php");
    exit();

}


// ==========================================
// GET SHORT NOTES FOR THIS UNIT
// ==========================================

$sql = "SELECT
            note_id,
            title,
            file_path,
            created_at

        FROM short_notes

        WHERE unit_id = ?

        ORDER BY note_id ASC";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $unit_id);

$stmt->execute();

$result = $stmt->get_result();

$notes = [];

while ($row = $result->fetch_assoc()) {

    $notes[] = $row;

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
        Short Notes |
        <?php echo htmlspecialchars($unit["unit_title"]); ?> |
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