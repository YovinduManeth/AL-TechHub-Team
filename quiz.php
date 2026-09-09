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
// GET QUIZ ID
// ==========================================

$quiz_id = $_GET["quiz"] ?? "";

if (!is_numeric($quiz_id)) {

    header("Location: dashboard.php");
    exit();

}

$quiz_id = (int)$quiz_id;


// ==========================================
// GET QUIZ DETAILS
// ==========================================

$sql = "SELECT
            quiz_id,
            unit_id,
            title,
            time_limit
        FROM quizzes
        WHERE quiz_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $quiz_id);

$stmt->execute();

$result = $stmt->get_result();

$quiz = $result->fetch_assoc();

$stmt->close();


// ==========================================
// CHECK QUIZ EXISTS
// ==========================================

if (!$quiz) {

    header("Location: dashboard.php");
    exit();

}

// ==========================================
// GET QUIZ QUESTIONS
// ==========================================

$sql = "SELECT
            question_id,
            question_text,
            option_a,
            option_b,
            option_c,
            option_d,
            correct_answer
        FROM quiz_questions
        WHERE quiz_id = ?
        ORDER BY RAND()
        LIMIT 10";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $quiz_id);

$stmt->execute();

$result = $stmt->get_result();

$questions = [];

while ($row = $result->fetch_assoc()) {

    $questions[] = $row;

}

$stmt->close();

// ==========================================
// STORE SELECTED QUESTIONS IN SESSION
// ==========================================

$_SESSION["quiz_questions"] = [];

foreach ($questions as $question) {

    $_SESSION["quiz_questions"][] = $question["question_id"];

}

$_SESSION["active_quiz_id"] = $quiz_id;


?>