<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";


// ==========================================
// REQUIRE LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html");
    exit();

}


// ==========================================
// CHECK LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}


// ==========================================
// GET LOGGED-IN USER
// ==========================================

$user_id = $_SESSION["user_id"];

$full_name = $_SESSION["full_name"];
$username = $_SESSION["username"];
$email = $_SESSION["email"];

// ==========================================
// GET LOGGED-IN STUDENT'S SUBJECTS
// ==========================================

$sql = "SELECT 
            subjects.subject_id,
            subjects.subject_code,
            subjects.subject_name,
            subjects.basket
        FROM student_subjects
        INNER JOIN subjects
            ON student_subjects.subject_id = subjects.subject_id
        WHERE student_subjects.user_id = ?
        ORDER BY subjects.subject_id";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$student_subjects = [];

while ($row = $result->fetch_assoc()) {

    $student_subjects[] = $row;

}

$stmt->close();