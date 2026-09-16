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