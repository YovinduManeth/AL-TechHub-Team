<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";

// ==========================================
// CHECK IF VIEWING SAVED RESULT
// ==========================================

$attempt_id = $_GET["attempt"] ?? "";

if ($attempt_id !== "") {

    if (!is_numeric($attempt_id)) {
        header("Location: dashboard.php");
        exit();
    }

    $attempt_id = (int)$attempt_id;

}


// ==========================================
// CHECK LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}

// ==========================================
// LOAD SAVED QUIZ ATTEMPT
// ==========================================

if ($attempt_id !== "") {

    $user_id = (int)$_SESSION["user_id"];

    $sql = "SELECT
                attempt_id,
                user_id,
                quiz_id,
                score,
                total_marks,
                percentage,
                correct_count
            FROM quiz_attempts
            WHERE attempt_id = ?
            AND user_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ii",
        $attempt_id,
        $user_id
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $attempt = $result->fetch_assoc();

    $stmt->close();


    if (!$attempt) {

        header("Location: dashboard.php");
        exit();

    }
    $quiz_id = (int)$attempt["quiz_id"];

$score = (int)$attempt["score"];

$total_marks = (int)$attempt["total_marks"];

$percentage = (float)$attempt["percentage"];

$correct_count = (int)$attempt["correct_count"];

$total_questions = 10;

$pass_mark = 50;

$passed = ($percentage >= $pass_mark);

$wrong_answers = [];

// ==========================================
// GET WRONG ANSWERS
// ==========================================

$sql = "SELECT
            a.question_id,
            ROW_NUMBER() OVER (ORDER BY a.question_id) AS question_number,
            a.selected_answer,
            a.correct_answer,
            q.question_text,
            q.option_a,
            q.option_b,
            q.option_c,
            q.option_d
        FROM quiz_attempt_answers a
        INNER JOIN quiz_questions q
            ON a.question_id = q.question_id
        WHERE a.attempt_id = ?
        AND a.selected_answer <> a.correct_answer
        ORDER BY a.question_id";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $attempt_id
);

$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    $wrong_answers[] = $row;

}

$stmt->close();

}


// ==========================================
// CHECK QUIZ SESSION
// ==========================================

if ($attempt_id === "") {

    if (
        !isset($_SESSION["active_quiz_id"]) ||
        !isset($_SESSION["quiz_questions"])
    ) {

        header("Location: dashboard.php");
        exit();

    }

}


if ($attempt_id === "") {

    $quiz_id = (int)$_SESSION["active_quiz_id"];

    $selected_question_ids =
        $_SESSION["quiz_questions"];

}

if ($attempt_id === "") {


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


if (!$quiz) {

    header("Location: dashboard.php");
    exit();

}


// ==========================================
// GET SELECTED QUESTIONS
// ==========================================

$questions = [];

foreach ($selected_question_ids as $question_id) {

    $sql = "SELECT
                question_id,
                question_text,
                option_a,
                option_b,
                option_c,
                option_d,
                correct_answer
            FROM quiz_questions
            WHERE question_id = ?
            AND quiz_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ii",
        $question_id,
        $quiz_id
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $question = $result->fetch_assoc();

    if ($question) {

        $questions[] = $question;

    }

    $stmt->close();

}


// ==========================================
// CALCULATE SCORE
// ==========================================

$correct_count = 0;

$total_questions = count($questions);

$marks_per_question = 10;




foreach ($questions as $index => $question) {

    $question_id = $question["question_id"];

    $submitted_answer =
        $_POST["question_" . $question_id] ?? "";

    $correct_answer =
        $question["correct_answer"];


    if ($submitted_answer === $correct_answer) {

        $correct_count++;

    } else {

        $wrong_answers[] = [

            "question_number" =>
                $index + 1,

            "question_text" =>
                $question["question_text"],

            "your_answer" =>
                $submitted_answer,

            "correct_answer" =>
                $correct_answer,

            "option_a" =>
                $question["option_a"],

            "option_b" =>
                $question["option_b"],

            "option_c" =>
                $question["option_c"],

            "option_d" =>
                $question["option_d"]

        ];

    }

}


// ==========================================
// CALCULATE MARKS
// ==========================================

$score =
    $correct_count * $marks_per_question;

$total_marks =
    $total_questions * $marks_per_question;


// ==========================================
// CALCULATE PERCENTAGE
// ==========================================

$percentage = 0;

if ($total_marks > 0) {

    $percentage =
        ($score / $total_marks) * 100;

}


// ==========================================
// PASS / FAIL
// ==========================================

$pass_mark = 50;

$passed =
    ($percentage >= $pass_mark);


// ==========================================
// SAVE QUIZ ATTEMPT
// ==========================================

$user_id = (int)$_SESSION["user_id"];

$sql = "INSERT INTO quiz_attempts
        (
            user_id,
            quiz_id,
            score,
            total_marks,
            percentage,
            correct_count
        )
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "iiiidi",
    $user_id,
    $quiz_id,
    $score,
    $total_marks,
    $percentage,
    $correct_count
);

$stmt->execute();

$attempt_id = $conn->insert_id;

$stmt->close();

// ==========================================
// SAVE INDIVIDUAL ANSWERS
// ==========================================

$sql = "INSERT INTO quiz_attempt_answers
        (
            attempt_id,
            question_id,
            selected_answer,
            correct_answer
        )
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

foreach ($questions as $question) {

    $question_id = (int)$question["question_id"];

    $selected_answer =
        $_POST["question_" . $question_id] ?? "";

    $correct_answer =
        $question["correct_answer"];

    $stmt->bind_param(
        "iiss",
        $attempt_id,
        $question_id,
        $selected_answer,
        $correct_answer
    );

    $stmt->execute();
}

$stmt->close();


// ==========================================
// REDIRECT AFTER SAVING ATTEMPT
// ==========================================

header("Location: quiz-result.php?attempt=" . $attempt_id);
exit();

}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Quiz Results | A/L TechHub</title>


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


<body class="quiz-result-page">


    <!-- =========================================
         NAVIGATION BAR
    ========================================== -->

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top dashboard-navbar">

        <div class="container">


            <!-- Brand -->

            <a
                class="navbar-brand fw-bold dashboard-brand"
                href="dashboard.html"
            >

                <i class="bi bi-mortarboard-fill me-1"></i>

                A/L TechHub

            </a>


            <!-- Mobile Toggle -->

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navPortal"
                aria-controls="navPortal"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >

                <span class="navbar-toggler-icon"></span>

            </button>


            <!-- Navbar Content -->

            <div
                class="collapse navbar-collapse"
                id="navPortal"
            >


                <!-- Navigation Links -->

                <ul class="navbar-nav me-auto ms-lg-4">


                    <li class="nav-item">

                        <a
                            class="nav-link dashboard-nav-link"
                            href="index.html"
                        >

                            <i class="bi bi-house me-1"></i>

                            Home

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link dashboard-nav-link active"
                            href="dashboard.html"
                        >

                            <i class="bi bi-grid-1x2-fill me-1"></i>

                            Dashboard

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link dashboard-nav-link"
                            href="help.html"
                        >

                            <i class="bi bi-question-circle me-1"></i>

                            Help

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link dashboard-nav-link"
                            href="contact.html"
                        >

                            <i class="bi bi-envelope me-1"></i>

                            Contact Us

                        </a>

                    </li>

                </ul>


                <!-- User -->

                <div class="d-flex align-items-center gap-3">

                    <a
                        href="profile.html"
                        class="dashboard-user text-decoration-none"
                    >
                        <i class="bi bi-person-circle me-1"></i>
                        User Account
                    </a>


                    <a
                        href="login.html"
                        class="btn btn-outline-primary btn-sm px-3"
                    >

                        <i class="bi bi-box-arrow-right me-1"></i>

                        Logout

                    </a>

                </div>

            </div>

        </div>

    </nav>
    <!-- =========================================
         MAIN CONTENT
    ========================================== -->

    <main class="container py-5">


        <div class="row justify-content-center">

            <div class="col-lg-8">


                <!-- =====================================
                     RESULT HEADER
                ====================================== -->

                <div class="result-card text-center mb-4">


                    <!-- Icon -->

                    <div class="result-icon">

                        <i class="bi bi-trophy-fill"></i>

                    </div>


                    <!-- Heading -->

                    <span class="result-label">
                        UNIT 01 ASSESSMENT
                    </span>

                    <h2 class="result-title">
                        Quiz Completed!
                    </h2>


                    <p class="result-description">
                        Unit 01: Fundamentals of Physics & Measurement
                        <span class="d-block mt-1">
                            <?php echo $correct_count; ?>
                                out of
                                <?php echo $total_questions; ?>
                                questions answered correctly
                        </span>
                    </p>



                    <!-- Score -->

                    <div class="result-score-box">

                        <span class="result-score-label">
                            Your Total Score
                        </span>


                       <div class="result-score">

                            <?php echo $score; ?>

                            / 

                            <?php echo $total_marks; ?>

                        </div>

                            <span class="result-status">

                                <?php if ($passed): ?>

                                    <i class="bi bi-check-circle-fill me-1"></i>

                                    Passed

                                <?php else: ?>

                                    <i class="bi bi-x-circle-fill me-1"></i>

                                    Failed

                                <?php endif; ?>

                            </span>
                    </div>



                    <!-- Buttons -->

                    <div class="result-actions">


                        <a
                            href="units.php"
                            class="btn-result-primary"
                        >

                            <i class="bi bi-arrow-left me-1"></i>

                            Back to Units

                        </a>


                        <a
                            href="quiz.php?quiz=<?php echo $quiz_id; ?>"
                            class="btn-result-outline"
                        >

                            <i class="bi bi-arrow-counterclockwise me-1"></i>

                            Try Another Quiz
                        </a>

                    </div>

                </div>