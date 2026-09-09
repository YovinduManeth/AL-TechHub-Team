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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Unit Assessment | A/L TechHub</title>

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
    <link rel="stylesheet" href="css/style.css">

</head>


<body class="quiz-page">


    <!-- =========================================
         QUIZ HEADER
    ========================================== -->

    <div class="quiz-header sticky-top">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center">

                <!-- Quiz Information -->

                <div>

                    <div class="quiz-header-title">

                        <i class="bi bi-pencil-square me-2"></i>

                        <?php echo htmlspecialchars($quiz["title"]); ?>

                    </div>

                    <small class="quiz-header-subtitle">

                        Science for Technology (SFT)

                    </small>

                </div>


                <!-- Timer -->

                <div class="quiz-timer">

                    <i class="bi bi-clock me-1"></i>

                    <span id="quizTimer">
                        <?php echo htmlspecialchars($quiz["time_limit"]); ?>:00
                    </span>

                </div>

            </div>

        </div>

    </div>
<!-- =========================================
         MAIN CONTENT
    ========================================== -->

    <main class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">


                <!-- Back to Units -->

                <div class="quiz-back mb-4">

                    <a href="unit.php?unit=<?php echo $quiz["unit_id"]; ?>">

                        <i class="bi bi-arrow-left me-1"></i>

                        Back to Unit

                    </a>

                </div>



                <!-- Quiz Introduction -->

                <div class="quiz-introduction mb-4">

                    <span class="quiz-label">

                            <?php echo htmlspecialchars($quiz["title"]); ?>

                        </span>

                        <h2>
                            Fundamentals of Physics & Measurement
                        </h2>

                    <p>
                        Test your understanding of the lessons covered in Unit 01.
                        This assessment contains questions selected from the Unit 01
                        quiz bank.
                    </p>


                <form action="quiz-result.php" method="POST">

                    <input
                        type="hidden"
                        name="quiz_id"
                        value="<?php echo $quiz_id; ?>"
                    >


                    <?php foreach ($questions as $index => $question): ?>

    <div class="quiz-card mb-4">

        <div class="quiz-card-header">

            <span class="quiz-question-number">

                Question
                <?php echo str_pad($index + 1, 2, "0", STR_PAD_LEFT); ?>

                of
                <?php echo count($questions); ?>

            </span>

            <span class="quiz-mark">
                10 Mark
            </span>

        </div>
         <h5 class="quiz-question">

            <?php
            echo htmlspecialchars(
                $question["question_text"]
            );
            ?>

        </h5>


        <!-- Option A -->

        <label class="quiz-option">

            <input
                type="radio"
                name="question_<?php echo $question["question_id"]; ?>"
                value="A"
                required
            >

            <span>
                A)
                <?php
                echo htmlspecialchars(
                    $question["option_a"]
                );
                ?>
            </span>

        </label>


        <!-- Option B -->

        <label class="quiz-option">

            <input
                type="radio"
                name="question_<?php echo $question["question_id"]; ?>"
                value="B"
            >

            <span>
                B)
                <?php
                echo htmlspecialchars(
                    $question["option_b"]
                );
                ?>
            </span>

        </label>


        <!-- Option C -->

        <label class="quiz-option">

            <input
                type="radio"
                name="question_<?php echo $question["question_id"]; ?>"
                value="C"
            >

            <span>
                C)
                <?php
                echo htmlspecialchars(
                    $question["option_c"]
                );
                ?>
            </span>

        </label>


        <!-- Option D -->

        <label class="quiz-option">

            <input
                type="radio"
                name="question_<?php echo $question["question_id"]; ?>"
                value="D"
            >

            <span>
                D)
                <?php
                echo htmlspecialchars(
                    $question["option_d"]
                );
                ?>
            </span>

        </label>

    </div>

<?php endforeach; ?>



                    <!-- =====================================
                         SUBMIT
                    ====================================== -->

                    <button
                        type="submit"
                        class="quiz-submit"
                    >

                        <i class="bi bi-send-check me-2"></i>

                        Submit Answers

                    </button>


                </form>

            </div>

        </div>

    </main>



    <!-- =========================================
         TIMER SCRIPT
    ========================================== -->

    <script>

    let secondsLeft = <?php echo (int)$quiz["time_limit"]; ?> * 60;

    const timerElem =
        document.getElementById("quizTimer");

    const quizForm =
        document.querySelector("form");


    const timer = setInterval(function () {

        let mins =
            Math.floor(secondsLeft / 60);

        let secs =
            secondsLeft % 60;


        secs =
            secs < 10
            ? "0" + secs
            : secs;


        timerElem.innerText =
            `${mins}:${secs}`;


        if (secondsLeft <= 0) {

            clearInterval(timer);

            timerElem.innerText = "00:00";

            quizForm.submit();

        }


        if (secondsLeft > 0) {

            secondsLeft--;

        }

    }, 1000);

</script>

</body>

</html>