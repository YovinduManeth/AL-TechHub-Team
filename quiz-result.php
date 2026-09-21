<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";


if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}

$user_id = (int)$_SESSION["user_id"];


$attempt_id = $_GET["attempt"] ?? "";

if ($attempt_id !== "") {

    if (!is_numeric($attempt_id)) {

        header("Location: dashboard.php");
        exit();

    }

    $attempt_id = (int)$attempt_id;

}


$quiz_id = 0;
$quiz = null;

$score = 0;
$total_marks = 0;
$percentage = 0;
$correct_count = 0;
$total_questions = 0;

$pass_mark = 50;
$passed = false;

$wrong_answers = [];


if ($attempt_id !== "") {


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

    $passed = ($percentage >= $pass_mark);


    $sql = "SELECT
                a.question_id,
                ROW_NUMBER() OVER (
                    ORDER BY a.question_id
                ) AS question_number,
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



else {



    if (!isset($_SESSION["active_quiz_id"])) {

        die("DEBUG: active_quiz_id session is missing.");

    }

    if (!isset($_SESSION["quiz_questions"])) {

        die("DEBUG: quiz_questions session is missing.");

    }


    $quiz_id = (int)$_SESSION["active_quiz_id"];

    $selected_question_ids =
        $_SESSION["quiz_questions"];


    $sql = "SELECT
                quizzes.quiz_id,
                quizzes.unit_id,
                quizzes.title,
                quizzes.time_limit,
                units.subject_id,
                units.grade,
                subjects.subject_code
            FROM quizzes
            INNER JOIN units
                ON quizzes.unit_id = units.unit_id
            INNER JOIN subjects
                ON units.subject_id = subjects.subject_id
            WHERE quizzes.quiz_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "i",
        $quiz_id
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $quiz = $result->fetch_assoc();

    $stmt->close();


    if (!$quiz) {

        die("DEBUG: QUIZ DATA NOT FOUND.");

    }


    $sql = "SELECT
                student_subject_id
            FROM student_subjects
            WHERE user_id = ?
            AND subject_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ii",
        $user_id,
        $quiz["subject_id"]
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {

        $stmt->close();

        header("Location: dashboard.php");
        exit();

    }

    $stmt->close();


    $questions = [];

    foreach ($selected_question_ids as $question_id) {

        $question_id = (int)$question_id;

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


   

    $correct_count = 0;

    $total_questions = count($questions);

    $marks_per_question = 10;


    foreach ($questions as $index => $question) {

        $question_id =
            (int)$question["question_id"];

        $submitted_answer =
            $_POST["question_" . $question_id] ?? "";

        $correct_answer =
            $question["correct_answer"];


        if ($submitted_answer === $correct_answer) {

            $correct_count++;

        }

        else {

            $wrong_answers[] = [

                "question_number" =>
                    $index + 1,

                "question_text" =>
                    $question["question_text"],

                "selected_answer" =>
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


    $score =
        $correct_count * $marks_per_question;

    $total_marks =
        $total_questions * $marks_per_question;



    if ($total_marks > 0) {

        $percentage =
            ($score / $total_marks) * 100;

    }

    else {

        $percentage = 0;

    }



    $passed =
        ($percentage >= $pass_mark);


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

        $question_id =
            (int)$question["question_id"];

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


    header(
        "Location: quiz-result.php?attempt=" .
        $attempt_id
    );

    exit();

}


$sql = "SELECT
            quizzes.quiz_id,
            quizzes.unit_id,
            quizzes.title,
            quizzes.time_limit,
            units.subject_id,
            units.grade,
            subjects.subject_code
        FROM quizzes
        INNER JOIN units
            ON quizzes.unit_id = units.unit_id
        INNER JOIN subjects
            ON units.subject_id = subjects.subject_id
        WHERE quizzes.quiz_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $quiz_id
);

$stmt->execute();

$result = $stmt->get_result();

$quiz = $result->fetch_assoc();

$stmt->close();


if (!$quiz) {

    die("DEBUG: QUIZ DATA NOT FOUND.");

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

    <title>
        Quiz Results | A/L TechHub
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


<body class="quiz-result-page">


    

    <nav
        class="navbar navbar-expand-lg navbar-light bg-white sticky-top dashboard-navbar"
    >

        <div class="container">


            <!-- Brand -->

            <a
                class="navbar-brand fw-bold dashboard-brand"
                href="index.html"
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
                            href="dashboard.php"
                        >

                            <i class="bi bi-grid-1x2-fill me-1"></i>

                            Dashboard

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link dashboard-nav-link"
                            href="contact.php"
                        >

                            <i class="bi bi-envelope me-1"></i>

                            Contact Us

                        </a>

                    </li>


                </ul>


                <!-- User -->

                <div class="d-flex align-items-center gap-3">

                    <a
                        href="profile.php"
                        class="dashboard-user text-decoration-none"
                    >

                        <i class="bi bi-person-circle me-1"></i>

                        User Account

                    </a>


                    <a
                        href="php/logout.php"
                        class="btn btn-outline-primary btn-sm px-3"
                    >

                        <i class="bi bi-box-arrow-right me-1"></i>

                        Logout

                    </a>

                </div>

            </div>

        </div>

    </nav>


   

    <main class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">



                <div class="result-card text-center mb-4">


                    <!-- Icon -->

                    <div class="result-icon">

                        <i class="bi bi-trophy-fill"></i>

                    </div>


                    <!-- Heading -->

                    <span class="result-label">

                        <?php
                        echo htmlspecialchars(
                            strtoupper($quiz["subject_code"])
                        );
                        ?>
                        -
                        Grade
                        <?php
                        echo htmlspecialchars(
                            $quiz["grade"]
                        );
                        ?>

                    </span>


                    <h2 class="result-title">

                        Quiz Completed!

                    </h2>


                    <p class="result-description">

                        <?php
                        echo htmlspecialchars(
                            $quiz["title"]
                        );
                        ?>

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

                                <i
                                    class="bi bi-check-circle-fill me-1"
                                ></i>

                                Passed

                            <?php else: ?>

                                <i
                                    class="bi bi-x-circle-fill me-1"
                                ></i>

                                Failed

                            <?php endif; ?>

                        </span>

                    </div>


                    

                    <div class="result-actions">


                        <!-- BACK TO UNITS -->

                        <a
                            href="units.php?subject=<?php echo urlencode($quiz['subject_code']); ?>&grade=<?php echo urlencode($quiz['grade']); ?>"
                            class="btn-result-primary"
                        >

                            <i
                                class="bi bi-arrow-left me-1"
                            ></i>

                            Back to Units

                        </a>


                        <!-- TRY AGAIN -->

                        <a
                            href="quiz.php?quiz=<?php echo $quiz_id; ?>"
                            class="btn-result-outline"
                        >

                            <i
                                class="bi bi-arrow-counterclockwise me-1"
                            ></i>

                            Try Again

                        </a>


                    </div>

                </div>



                <div class="answer-card">


                    <div class="answer-heading">


                        <div class="answer-heading-icon">

                            <i class="bi bi-list-check"></i>

                        </div>


                        <div>

                            <h5>
                                Answer Breakdown
                            </h5>

                            <p>
                                Review your answers and see the correct answers.
                            </p>

                        </div>

                    </div>


                    <?php if (count($wrong_answers) > 0): ?>


                        <?php foreach ($wrong_answers as $wrong): ?>


                            <div
                                class="answer-item incorrect-answer"
                            >


                                <div class="answer-item-top">


                                    <span
                                        class="answer-question-number"
                                    >

                                        Question

                                        <?php
                                        echo str_pad(
                                            $wrong["question_number"],
                                            2,
                                            "0",
                                            STR_PAD_LEFT
                                        );
                                        ?>

                                    </span>


                                    <span class="answer-correct">

                                        <i
                                            class="bi bi-x-circle-fill me-1"
                                        ></i>

                                        Incorrect

                                    </span>


                                </div>


                                <p class="answer-question">

                                    <?php
                                    echo htmlspecialchars(
                                        $wrong["question_text"]
                                    );
                                    ?>

                                </p>


                                <!-- YOUR ANSWER -->

                                <div
                                    class="answer-choice your-answer"
                                >

                                    <i
                                        class="bi bi-x-circle-fill"
                                    ></i>


                                    <span>

                                        Your Answer:

                                        <?php

                                        $your_answer =
                                            $wrong["selected_answer"];


                                        if ($your_answer === "") {

                                            echo "Not Answered";

                                        }

                                        else {

                                            $your_option =
                                                $wrong[
                                                    "option_" .
                                                    strtolower(
                                                        $your_answer
                                                    )
                                                ];


                                            echo htmlspecialchars(
                                                $your_answer
                                            );

                                            echo ") ";

                                            echo htmlspecialchars(
                                                $your_option
                                            );

                                        }

                                        ?>

                                    </span>

                                </div>


                                <!-- CORRECT ANSWER -->

                                <div
                                    class="answer-choice correct-answer"
                                >

                                    <i
                                        class="bi bi-check-circle-fill"
                                    ></i>


                                    <span>

                                        Correct Answer:

                                        <?php

                                        $correct_answer =
                                            $wrong["correct_answer"];


                                        $correct_option =
                                            $wrong[
                                                "option_" .
                                                strtolower(
                                                    $correct_answer
                                                )
                                            ];


                                        echo htmlspecialchars(
                                            $correct_answer
                                        );

                                        echo ") ";

                                        echo htmlspecialchars(
                                            $correct_option
                                        );

                                        ?>

                                    </span>

                                </div>


                            </div>


                        <?php endforeach; ?>


                    <?php else: ?>


                        <div class="text-center py-4">


                            <i
                                class="bi bi-check-circle-fill fs-1 text-success"
                            ></i>


                            <h5 class="mt-3">

                                Perfect Score!

                            </h5>


                            <p class="text-muted">

                                You answered all questions correctly.

                            </p>


                        </div>


                    <?php endif; ?>


                </div>


            </div>

        </div>

    </main>


    <!-- Bootstrap JavaScript -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    ></script>


</body>

</html>