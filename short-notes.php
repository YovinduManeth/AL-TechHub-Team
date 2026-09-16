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