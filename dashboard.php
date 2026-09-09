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

// ==========================================
// GET SUBJECT PROGRESS
// ==========================================

$subject_progress = [];

foreach ($student_subjects as $subject) {

    $subject_id = (int)$subject["subject_id"];

    $sql = "SELECT
                COUNT(DISTINCT units.unit_id) AS total_units,

                COUNT(
                    DISTINCT CASE
                        WHEN unit_totals.total_lessons > 0
                        AND unit_totals.completed_lessons = unit_totals.total_lessons
                        THEN units.unit_id
                    END
                ) AS completed_units

            FROM units

            LEFT JOIN (

                SELECT
                    units.unit_id,

                    COUNT(lessons.lesson_id) AS total_lessons,

                    COUNT(
                        CASE
                            WHEN student_progress.completed = 1
                            THEN 1
                        END
                    ) AS completed_lessons

                FROM units

                LEFT JOIN lessons
                    ON units.unit_id = lessons.unit_id

                LEFT JOIN student_progress
                    ON lessons.lesson_id = student_progress.lesson_id
                    AND student_progress.user_id = ?

                WHERE units.subject_id = ?

                GROUP BY units.unit_id

            ) AS unit_totals

                ON units.unit_id = unit_totals.unit_id

            WHERE units.subject_id = ?";

    $progress_stmt = $conn->prepare($sql);

    $progress_stmt->bind_param(
        "iii",
        $user_id,
        $subject_id,
        $subject_id
    );

    $progress_stmt->execute();

    $progress_result =
        $progress_stmt->get_result();

    $progress_data =
        $progress_result->fetch_assoc();

    $subject_progress[$subject_id] = [

        "total_units" =>
            (int)$progress_data["total_units"],

        "completed_units" =>
            (int)$progress_data["completed_units"]

    ];

    $progress_stmt->close();

}

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
            quizzes.title
        FROM quiz_attempts
        INNER JOIN quizzes
            ON quiz_attempts.quiz_id = quizzes.quiz_id
        WHERE quiz_attempts.user_id = ?
        ORDER BY quiz_attempts.attempted_at ASC";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$quiz_history = [];

while ($row = $result->fetch_assoc()) {

    $quiz_history[] = $row;

}

$stmt->close();

// ==========================================
// GET OVERALL LESSON PROGRESS
// ==========================================

$sql = "SELECT
            COUNT(lessons.lesson_id) AS total_lessons,

            COUNT(
                CASE
                    WHEN student_progress.completed = 1
                    THEN 1
                END
            ) AS completed_lessons

        FROM lessons

        INNER JOIN units
            ON lessons.unit_id = units.unit_id

        INNER JOIN student_subjects
            ON units.subject_id = student_subjects.subject_id

        LEFT JOIN student_progress
            ON lessons.lesson_id = student_progress.lesson_id
            AND student_progress.user_id = ?

        WHERE student_subjects.user_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ii",
    $user_id,
    $user_id
);

$stmt->execute();

$result = $stmt->get_result();

$overall_progress = $result->fetch_assoc();

$stmt->close();


// ==========================================
// CALCULATE OVERALL PROGRESS PERCENTAGE
// ==========================================

$total_lessons = (int)$overall_progress["total_lessons"];

$completed_lessons = (int)$overall_progress["completed_lessons"];

$overall_progress_percentage = 0;

if ($total_lessons > 0) {

    $overall_progress_percentage =
        round(
            ($completed_lessons / $total_lessons) * 100
        );

}


?>