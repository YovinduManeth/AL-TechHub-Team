<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";


// ==========================================
// REQUIRE LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}


// ==========================================
// GET LOGGED-IN USER
// ==========================================

$user_id = (int)$_SESSION["user_id"];

$full_name = $_SESSION["full_name"];
$username = $_SESSION["username"];


// ==========================================
// GET QUIZ HISTORY
// ==========================================

$sql = "SELECT
            quiz_attempts.attempt_id,
            quiz_attempts.quiz_id,
            quiz_attempts.score,
            quiz_attempts.total_marks,
            quiz_attempts.percentage,
            quiz_attempts.correct_count,
            quiz_attempts.attempted_at,

            quizzes.title AS quiz_title,

            units.unit_number,
            units.unit_title,

            subjects.subject_code,
            subjects.subject_name

        FROM quiz_attempts

        INNER JOIN quizzes
            ON quiz_attempts.quiz_id = quizzes.quiz_id

        INNER JOIN units
            ON quizzes.unit_id = units.unit_id

        INNER JOIN subjects
            ON units.subject_id = subjects.subject_id

        WHERE quiz_attempts.user_id = ?

        ORDER BY quiz_attempts.attempted_at DESC";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$quiz_history = [];

while ($row = $result->fetch_assoc()) {

    $quiz_history[] = $row;

}

$stmt->close();

?>