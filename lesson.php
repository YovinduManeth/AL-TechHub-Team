<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";


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
// GET LESSON ID
// ==========================================

$lesson_id = $_GET["lesson"] ?? "";


// Make sure lesson ID is a number

if (!is_numeric($lesson_id)) {

    header("Location: dashboard.php");
    exit();

}

$lesson_id = (int)$lesson_id;


// ==========================================
// GET LESSON DETAILS
// ==========================================

$sql = "SELECT
            lessons.lesson_id,
            lessons.unit_id,
            lessons.lesson_number,
            lessons.title,
            lessons.description,
            lessons.video_path,
            lessons.video_1080p_path,
            lessons.video_720p_path,
            lessons.video_480p_path,
            lessons.video_360p_path,
            lessons.audio_path,
            lessons.duration_minutes,

            units.unit_number,
            units.unit_title,
            units.grade,

            subjects.subject_code,
            subjects.subject_name

        FROM lessons

        INNER JOIN units
            ON lessons.unit_id = units.unit_id

        INNER JOIN subjects
            ON units.subject_id = subjects.subject_id

        WHERE lessons.lesson_id = ?";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $lesson_id);

$stmt->execute();

$result = $stmt->get_result();

$lesson = $result->fetch_assoc();

$stmt->close();


// ==========================================
// CHECK LESSON EXISTS
// ==========================================

if (!$lesson) {

    header("Location: dashboard.php");
    exit();

}

?>

