<?php

require_once "php/db.php";



$message = "";
$message_type = "";



$selected_grade = $_GET["grade"] ?? "";

$selected_subject_id = isset($_GET["subject_id"])
    ? (int) $_GET["subject_id"]
    : 0;

$selected_unit_id = isset($_GET["unit_id"])
    ? (int) $_GET["unit_id"]
    : 0;



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $action = $_POST["action"] ?? "";


    if ($action === "add_question") {

        $post_grade = $_POST["grade"] ?? "";

        $post_subject_id = isset($_POST["subject_id"])
            ? (int) $_POST["subject_id"]
            : 0;

        $post_unit_id = isset($_POST["unit_id"])
            ? (int) $_POST["unit_id"]
            : 0;


        $question_text = trim(
            $_POST["question_text"] ?? ""
        );

        $option_a = trim(
            $_POST["option_a"] ?? ""
        );

        $option_b = trim(
            $_POST["option_b"] ?? ""
        );

        $option_c = trim(
            $_POST["option_c"] ?? ""
        );

        $option_d = trim(
            $_POST["option_d"] ?? ""
        );

        $correct_answer = strtoupper(
            trim($_POST["correct_answer"] ?? "")
        );


        if (
            $post_grade === "" ||
            $post_subject_id <= 0 ||
            $post_unit_id <= 0 ||
            $question_text === "" ||
            $option_a === "" ||
            $option_b === "" ||
            $option_c === "" ||
            $option_d === "" ||
            !in_array(
                $correct_answer,
                ["A", "B", "C", "D"],
                true
            )
        ) {

            $message = "Please fill in all question fields.";

            $message_type = "danger";

        } else {


           
            $unit_check_stmt = $conn->prepare("
                SELECT
                    unit_id,
                    subject_id,
                    grade,
                    unit_number,
                    unit_title
                FROM units
                WHERE unit_id = ?
                  AND subject_id = ?
                  AND grade = ?
                LIMIT 1
            ");

            $unit_check_stmt->bind_param(
                "iis",
                $post_unit_id,
                $post_subject_id,
                $post_grade
            );

            $unit_check_stmt->execute();

            $unit_check_result =
                $unit_check_stmt->get_result();

            $valid_unit =
                $unit_check_result->fetch_assoc();

            $unit_check_stmt->close();


            if (!$valid_unit) {

                $message =
                    "Invalid Grade, Subject or Unit selection.";

                $message_type = "danger";

            } else {



                $quiz_check_stmt = $conn->prepare("
                    SELECT
                        quiz_id,
                        title,
                        time_limit
                    FROM quizzes
                    WHERE unit_id = ?
                    LIMIT 1
                ");

                $quiz_check_stmt->bind_param(
                    "i",
                    $post_unit_id
                );

                $quiz_check_stmt->execute();

                $quiz_check_result =
                    $quiz_check_stmt->get_result();

                $existing_quiz =
                    $quiz_check_result->fetch_assoc();

                $quiz_check_stmt->close();


                if (!$existing_quiz) {

                    $message =
                        "No quiz exists for this unit.";

                    $message_type = "danger";

                } else {


                    $quiz_id =
                        (int) $existing_quiz["quiz_id"];


                 
                    $count_stmt = $conn->prepare("
                        SELECT COUNT(*) AS total
                        FROM quiz_questions
                        WHERE quiz_id = ?
                    ");

                    $count_stmt->bind_param(
                        "i",
                        $quiz_id
                    );

                    $count_stmt->execute();

                    $count_result =
                        $count_stmt->get_result();

                    $count_row =
                        $count_result->fetch_assoc();

                    $count_stmt->close();


                    $current_count =
                        (int) $count_row["total"];


                 

                    if ($current_count >= 20) {

                        $message =
                            "This quiz already contains 20 questions. You cannot add another question.";

                        $message_type = "warning";

                    } else {



                        $insert_stmt = $conn->prepare("
                            INSERT INTO quiz_questions
                            (
                                quiz_id,
                                question_text,
                                option_a,
                                option_b,
                                option_c,
                                option_d,
                                correct_answer
                            )
                            VALUES (?, ?, ?, ?, ?, ?, ?)
                        ");

                        $insert_stmt->bind_param(
                            "issssss",
                            $quiz_id,
                            $question_text,
                            $option_a,
                            $option_b,
                            $option_c,
                            $option_d,
                            $correct_answer
                        );


                        if ($insert_stmt->execute()) {

                            $insert_stmt->close();


                            $new_count =
                                $current_count + 1;



                            header(
                                "Location: quiz-bank.php?grade=" .
                                urlencode($post_grade) .
                                "&subject_id=" .
                                $post_subject_id .
                                "&unit_id=" .
                                $post_unit_id .
                                "&success=1&added=" .
                                $new_count
                            );

                            exit;

                        } else {

                            $message =
                                "Failed to add the question. Please try again.";

                            $message_type = "danger";

                            $insert_stmt->close();

                        }

                    }

                }

            }

        }


        // Preserve selected values after an error

        $selected_grade =
            $post_grade;

        $selected_subject_id =
            $post_subject_id;

        $selected_unit_id =
            $post_unit_id;

    }

}



if (isset($_GET["success"]) && $_GET["success"] === "1") {

    $added_count = isset($_GET["added"])
        ? (int) $_GET["added"]
        : 0;

    $message =
        "Question added successfully. The quiz now contains " .
        $added_count .
        " / 20 questions.";

    $message_type = "success";

}


$subjects = [];

$subject_sql = "
    SELECT
        subject_id,
        subject_code,
        subject_name
    FROM subjects
    ORDER BY subject_name
";

$subject_result =
    $conn->query($subject_sql);

if ($subject_result) {

    while ($row = $subject_result->fetch_assoc()) {

        $subjects[] = $row;

    }

}


$units = [];

$unit_sql = "
    SELECT
        unit_id,
        subject_id,
        grade,
        unit_number,
        unit_title
    FROM units
    ORDER BY grade, subject_id, unit_number
";

$unit_result =
    $conn->query($unit_sql);

if ($unit_result) {

    while ($row = $unit_result->fetch_assoc()) {

        $units[] = $row;

    }

}


$quiz = null;

$questions = [];

$question_count = 0;

$selected_unit = null;



if (
    $selected_grade !== "" &&
    $selected_subject_id > 0 &&
    $selected_unit_id > 0
) {

    $unit_stmt = $conn->prepare("
        SELECT
            unit_id,
            subject_id,
            grade,
            unit_number,
            unit_title
        FROM units
        WHERE unit_id = ?
          AND subject_id = ?
          AND grade = ?
        LIMIT 1
    ");

    $unit_stmt->bind_param(
        "iis",
        $selected_unit_id,
        $selected_subject_id,
        $selected_grade
    );

    $unit_stmt->execute();

    $unit_result =
        $unit_stmt->get_result();

    $selected_unit =
        $unit_result->fetch_assoc();

    $unit_stmt->close();


    
    if ($selected_unit) {

        $quiz_stmt = $conn->prepare("
            SELECT
                quiz_id,
                unit_id,
                title,
                time_limit,
                created_at
            FROM quizzes
            WHERE unit_id = ?
            LIMIT 1
        ");

        $quiz_stmt->bind_param(
            "i",
            $selected_unit_id
        );

        $quiz_stmt->execute();

        $quiz_result =
            $quiz_stmt->get_result();

        $quiz =
            $quiz_result->fetch_assoc();

        $quiz_stmt->close();


        
        if ($quiz) {

            $quiz_id =
                (int) $quiz["quiz_id"];


            $question_stmt = $conn->prepare("
                SELECT
                    question_id,
                    question_text,
                    option_a,
                    option_b,
                    option_c,
                    option_d,
                    correct_answer
                FROM quiz_questions
                WHERE quiz_id = ?
                ORDER BY question_id ASC
            ");

            $question_stmt->bind_param(
                "i",
                $quiz_id
            );

            $question_stmt->execute();

            $question_result =
                $question_stmt->get_result();


            while (
                $row =
                $question_result->fetch_assoc()
            ) {

                $questions[] = $row;

            }


            $question_count =
                count($questions);


            $question_stmt->close();

        }

    }

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

    <title>Quiz Bank | A/L TechHub</title>


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


<body class="admin-page">


   

    <nav class="navbar navbar-expand-lg admin-navbar sticky-top">

        <div class="container">


            <a
                class="navbar-brand fw-bold admin-brand"
                href="admin-upload.html"
            >

                <i class="bi bi-shield-lock-fill me-1"></i>

                A/L TechHub

                <span class="admin-brand-label">
                    Admin
                </span>

            </a>


            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#adminNavbar"
                aria-controls="adminNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >

                <span class="navbar-toggler-icon"></span>

            </button>


            <div
                class="collapse navbar-collapse"
                id="adminNavbar"
            >

                <ul class="navbar-nav me-auto ms-lg-4">


                    <li class="nav-item">

                        <a
                            class="nav-link admin-nav-link"
                            href="admin-upload.html"
                        >

                            <i class="bi bi-cloud-upload me-1"></i>

                            Upload Content

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link admin-nav-link active"
                            href="quiz-bank.php"
                        >

                            <i class="bi bi-question-circle me-1"></i>

                            Quiz Bank

                        </a>

                    </li>

                </ul>


                <div class="d-flex align-items-center gap-3">

                    <span class="admin-user">

                        <i class="bi bi-person-circle me-1"></i>

                        Administrator

                    </span>


                    <a
                        href="login.html"
                        class="btn btn-admin-logout btn-sm px-3"
                    >

                        <i class="bi bi-box-arrow-right me-1"></i>

                        Logout

                    </a>

                </div>

            </div>

        </div>

    </nav>


  
    <main class="container py-5">


        <!-- PAGE HEADING -->

        <div class="admin-page-heading mb-4">

            <p class="admin-label mb-1">
                QUIZ MANAGEMENT
            </p>

            <h1 class="fw-bold mb-2">
                Quiz Bank
            </h1>

            <p class="text-muted mb-0">
                Create and manage assessment questions for each
                subject and unit.
            </p>

        </div>


        <?php if ($message !== ""): ?>

            <div
                class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show"
                role="alert"
            >

                <?php if ($message_type === "success"): ?>

                    <i class="bi bi-check-circle-fill me-2"></i>

                <?php elseif ($message_type === "warning"): ?>

                    <i class="bi bi-exclamation-triangle-fill me-2"></i>

                <?php else: ?>

                    <i class="bi bi-x-circle-fill me-2"></i>

                <?php endif; ?>


                <?= htmlspecialchars($message) ?>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>

            </div>

        <?php endif; ?>


        
        <div class="row justify-content-center mb-4">

            <div class="col-lg-9 col-xl-8">

                <div class="admin-upload-card">


                    <div class="admin-upload-header">

                        <div class="admin-upload-icon">

                            <i class="bi bi-funnel-fill"></i>

                        </div>


                        <div>

                            <h4 class="fw-bold mb-1">
                                Select Question Bank
                            </h4>

                            <p class="mb-0">
                                Select the grade, subject and unit.
                            </p>

                        </div>

                    </div>


                    <div class="admin-upload-body">

                        <form
                            method="GET"
                            action="quiz-bank.php"
                            id="quizSelectionForm"
                        >


                            <!-- Grade -->

                            <div class="mb-3">

                                <label
                                    class="form-label fw-bold"
                                >

                                    <i class="bi bi-mortarboard me-1"></i>

                                    Grade

                                </label>


                                <select
                                    name="grade"
                                    id="gradeSelect"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        -- Select Grade --
                                    </option>


                                    <option
                                        value="12"
                                        <?= $selected_grade === "12"
                                            ? "selected"
                                            : "" ?>
                                    >

                                        Grade 12

                                    </option>


                                    <option
                                        value="13"
                                        <?= $selected_grade === "13"
                                            ? "selected"
                                            : "" ?>
                                    >

                                        Grade 13

                                    </option>

                                </select>

                            </div>


                            <!-- Subject -->

                            <div class="mb-3">

                                <label
                                    class="form-label fw-bold"
                                >

                                    <i class="bi bi-book me-1"></i>

                                    Subject

                                </label>


                                <select
                                    name="subject_id"
                                    id="subjectSelect"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        -- Select Subject --
                                    </option>


                                    <?php foreach ($subjects as $subject): ?>

                                        <option
                                            value="<?= (int) $subject["subject_id"] ?>"
                                            <?= $selected_subject_id ===
                                                (int) $subject["subject_id"]
                                                ? "selected"
                                                : "" ?>
                                        >

                                            <?= htmlspecialchars(
                                                $subject["subject_name"]
                                            ) ?>

                                            (<?= htmlspecialchars(
                                                $subject["subject_code"]
                                            ) ?>)

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>


                            <!-- Unit -->

                            <div class="mb-4">

                                <label
                                    class="form-label fw-bold"
                                >

                                    <i class="bi bi-layers me-1"></i>

                                    Unit

                                </label>


                                <select
                                    name="unit_id"
                                    id="unitSelect"
                                    class="form-select"
                                    required
                                    disabled
                                >

                                    <option value="">
                                        -- Select Unit --
                                    </option>

                                </select>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-admin-primary w-100 py-3 fw-bold"
                                id="viewQuizButton"
                                disabled
                            >

                                <i class="bi bi-eye me-1"></i>

                                View Question Bank

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>



        <?php if ($selected_unit): ?>

            <div class="row justify-content-center">

                <div class="col-lg-9 col-xl-8">

                    <div class="admin-upload-card">


                        <!-- HEADER -->

                        <div class="admin-upload-header">

                            <div class="admin-upload-icon">

                                <i class="bi bi-question-square-fill"></i>

                            </div>


                            <div>

                                <h4 class="fw-bold mb-1">

                                    <?= htmlspecialchars(
                                        $selected_unit["unit_title"]
                                    ) ?>

                                </h4>


                                <p class="mb-0">

                                    Grade
                                    <?= htmlspecialchars(
                                        $selected_unit["grade"]
                                    ) ?>

                                    · Unit
                                    <?= str_pad(
                                        $selected_unit["unit_number"],
                                        2,
                                        "0",
                                        STR_PAD_LEFT
                                    ) ?>

                                </p>

                            </div>

                        </div>


                        <div class="admin-upload-body">


                            <?php if (!$quiz): ?>

                                <div class="alert alert-warning">

                                    <i
                                        class="bi bi-exclamation-triangle me-2"
                                    ></i>

                                    No quiz has been created for this
                                    unit yet.

                                </div>


                            <?php else: ?>


                                <!-- QUIZ INFO -->

                                <div class="alert alert-light border">

                                    <strong>

                                        <?= htmlspecialchars(
                                            $quiz["title"]
                                        ) ?>

                                    </strong>

                                    <br>


                                    <span class="text-muted">

                                        <?= $question_count ?>
                                        / 20 Questions

                                    </span>

                                </div>


                               
                                <?php if ($question_count < 20): ?>

                                    <div class="border rounded-4 p-4">

                                        <h5 class="fw-bold mb-3">

                                            <i
                                                class="bi bi-plus-circle me-1"
                                            ></i>

                                            Add Quiz Question

                                        </h5>


                                        <form
                                            method="POST"
                                            action="quiz-bank.php?grade=<?= urlencode(
                                                $selected_grade
                                            ) ?>&subject_id=<?= $selected_subject_id ?>&unit_id=<?= $selected_unit_id ?>"
                                        >


                                            <input
                                                type="hidden"
                                                name="action"
                                                value="add_question"
                                            >


                                            <input
                                                type="hidden"
                                                name="grade"
                                                value="<?= htmlspecialchars(
                                                    $selected_grade
                                                ) ?>"
                                            >


                                            <input
                                                type="hidden"
                                                name="subject_id"
                                                value="<?= $selected_subject_id ?>"
                                            >


                                            <input
                                                type="hidden"
                                                name="unit_id"
                                                value="<?= $selected_unit_id ?>"
                                            >


                                            <!-- QUESTION -->

                                            <div class="mb-4">

                                                <label
                                                    class="form-label fw-bold"
                                                >

                                                    <i
                                                        class="bi bi-chat-square-text me-1"
                                                    ></i>

                                                    Question

                                                </label>


                                                <textarea
                                                    name="question_text"
                                                    class="form-control"
                                                    rows="4"
                                                    placeholder="Enter the question..."
                                                    required
                                                ></textarea>

                                            </div>


                                            <!-- OPTION A -->

                                            <div class="mb-3">

                                                <label
                                                    class="form-label fw-bold"
                                                >
                                                    Option A
                                                </label>


                                                <input
                                                    type="text"
                                                    name="option_a"
                                                    class="form-control"
                                                    placeholder="Enter option A"
                                                    required
                                                >

                                            </div>


                                            <!-- OPTION B -->

                                            <div class="mb-3">

                                                <label
                                                    class="form-label fw-bold"
                                                >
                                                    Option B
                                                </label>


                                                <input
                                                    type="text"
                                                    name="option_b"
                                                    class="form-control"
                                                    placeholder="Enter option B"
                                                    required
                                                >

                                            </div>


                                            <!-- OPTION C -->

                                            <div class="mb-3">

                                                <label
                                                    class="form-label fw-bold"
                                                >
                                                    Option C
                                                </label>


                                                <input
                                                    type="text"
                                                    name="option_c"
                                                    class="form-control"
                                                    placeholder="Enter option C"
                                                    required
                                                >

                                            </div>


                                            <!-- OPTION D -->

                                            <div class="mb-4">

                                                <label
                                                    class="form-label fw-bold"
                                                >
                                                    Option D
                                                </label>


                                                <input
                                                    type="text"
                                                    name="option_d"
                                                    class="form-control"
                                                    placeholder="Enter option D"
                                                    required
                                                >

                                            </div>


                                            <!-- CORRECT ANSWER -->

                                            <div class="mb-4">

                                                <label
                                                    class="form-label fw-bold"
                                                >

                                                    <i
                                                        class="bi bi-check-circle me-1"
                                                    ></i>

                                                    Correct Answer

                                                </label>


                                                <select
                                                    name="correct_answer"
                                                    class="form-select"
                                                    required
                                                >

                                                    <option
                                                        value=""
                                                        selected
                                                        disabled
                                                    >

                                                        -- Select Correct Answer --

                                                    </option>


                                                    <option value="A">
                                                        Option A
                                                    </option>


                                                    <option value="B">
                                                        Option B
                                                    </option>


                                                    <option value="C">
                                                        Option C
                                                    </option>


                                                    <option value="D">
                                                        Option D
                                                    </option>

                                                </select>

                                            </div>


                                            <!-- SUBMIT -->

                                            <button
                                                type="submit"
                                                class="btn btn-admin-primary w-100 py-3 fw-bold"
                                            >

                                                <i
                                                    class="bi bi-plus-circle me-1"
                                                ></i>

                                                Add Question

                                            </button>


                                        </form>

                                    </div>


                                <?php else: ?>

                                    <div class="alert alert-success">

                                        <i
                                            class="bi bi-check-circle-fill me-2"
                                        ></i>

                                        This quiz already contains the
                                        maximum 20 questions.

                                    </div>

                                <?php endif; ?>


                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        <?php endif; ?>


        
        <?php if ($selected_unit && $quiz): ?>

            <div class="mt-5">


                <div class="admin-page-heading mb-3">

                    <p class="admin-label mb-1">
                        QUESTION COLLECTION
                    </p>


                    <h4 class="fw-bold mb-1">

                        Grade
                        <?= htmlspecialchars(
                            $selected_unit["grade"]
                        ) ?>

                        —

                        <?= htmlspecialchars(
                            $quiz["title"]
                        ) ?>

                    </h4>


                    <p class="text-muted small mb-0">

                        <?= $question_count ?>
                        / 20 Questions currently available.

                    </p>

                </div>


                <?php if ($question_count === 0): ?>

                    <div class="alert alert-info">

                        <i
                            class="bi bi-info-circle me-2"
                        ></i>

                        No questions have been added to this quiz yet.

                    </div>

                <?php endif; ?>


                <?php foreach (
                    $questions
                    as $index => $question
                ): ?>


                    <div
                        class="card border-0 shadow-sm rounded-4 mb-3"
                    >

                        <div class="card-body p-4">


                            <div
                                class="d-flex justify-content-between align-items-start mb-2"
                            >

                                <span class="badge bg-primary">

                                    Q<?= str_pad(
                                        $index + 1,
                                        3,
                                        "0",
                                        STR_PAD_LEFT
                                    ) ?>

                                </span>


                                <span
                                    class="badge bg-light text-dark"
                                >

                                    1 Mark

                                </span>

                            </div>


                            <h6 class="fw-bold">

                                <?= nl2br(
                                    htmlspecialchars(
                                        $question["question_text"]
                                    )
                                ) ?>

                            </h6>


                            <div
                                class="row g-2 small text-muted"
                            >


                                <div class="col-md-6">

                                    A)
                                    <?= htmlspecialchars(
                                        $question["option_a"]
                                    ) ?>

                                </div>


                                <div class="col-md-6">

                                    B)
                                    <?= htmlspecialchars(
                                        $question["option_b"]
                                    ) ?>

                                </div>


                                <div class="col-md-6">

                                    C)
                                    <?= htmlspecialchars(
                                        $question["option_c"]
                                    ) ?>

                                </div>


                                <div class="col-md-6">

                                    D)
                                    <?= htmlspecialchars(
                                        $question["option_d"]
                                    ) ?>

                                </div>


                            </div>


                            <div class="mt-3">

                                <span class="badge bg-success">

                                    Correct Answer:
                                    <?= htmlspecialchars(
                                        $question["correct_answer"]
                                    ) ?>

                                </span>

                            </div>


                        </div>

                    </div>


                <?php endforeach; ?>


            </div>

        <?php endif; ?>


    </main>


    <script>

        const units = <?= json_encode(
            $units,
            JSON_UNESCAPED_UNICODE |
            JSON_HEX_TAG |
            JSON_HEX_AMP |
            JSON_HEX_APOS |
            JSON_HEX_QUOT
        ) ?>;


        const gradeSelect =
            document.getElementById("gradeSelect");

        const subjectSelect =
            document.getElementById("subjectSelect");

        const unitSelect =
            document.getElementById("unitSelect");

        const viewQuizButton =
            document.getElementById("viewQuizButton");


        function updateUnits() {

            const grade =
                gradeSelect.value;

            const subjectId =
                subjectSelect.value;

            const currentUnitId =
                "<?= (int) $selected_unit_id ?>";


            unitSelect.innerHTML = "";


            const defaultOption =
                document.createElement("option");

            defaultOption.value = "";

            defaultOption.textContent =
                "-- Select Unit --";

            unitSelect.appendChild(
                defaultOption
            );


            if (!grade || !subjectId) {

                unitSelect.disabled = true;

                viewQuizButton.disabled = true;

                return;

            }


            const filteredUnits =
                units.filter(function(unit) {

                    return (
                        String(unit.grade) ===
                            String(grade)

                        &&

                        String(unit.subject_id) ===
                            String(subjectId)
                    );

                });


            filteredUnits.forEach(
                function(unit) {

                    const option =
                        document.createElement(
                            "option"
                        );


                    option.value =
                        unit.unit_id;


                    option.textContent =
                        "Unit " +
                        String(
                            unit.unit_number
                        ).padStart(2, "0") +
                        " - " +
                        unit.unit_title;


                    if (
                        currentUnitId !== "0"
                        &&
                        String(unit.unit_id) ===
                            currentUnitId
                    ) {

                        option.selected =
                            true;

                    }


                    unitSelect.appendChild(
                        option
                    );

                }
            );


            unitSelect.disabled =
                filteredUnits.length === 0;


            viewQuizButton.disabled =
                true;

        }


        function updateViewButton() {

            viewQuizButton.disabled =
                !(
                    gradeSelect.value
                    &&
                    subjectSelect.value
                    &&
                    unitSelect.value
                );

        }


        gradeSelect.addEventListener(
            "change",
            function() {

                updateUnits();

            }
        );


        subjectSelect.addEventListener(
            "change",
            function() {

                updateUnits();

            }
        );


        unitSelect.addEventListener(
            "change",
            function() {

                updateViewButton();

            }
        );


        updateUnits();

        updateViewButton();

    </script>


    <!-- Bootstrap JavaScript -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    ></script>


</body>

</html>