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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard | A/L TechHub</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- ==============================
     Navigation Bar
=============================== -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top dashboard-navbar">

    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand fw-bold dashboard-brand" href="index.html">
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
        <div class="collapse navbar-collapse" id="navPortal">

            <!-- Left Navigation Links -->
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


            <!-- Right Side -->

<div class="d-flex align-items-center gap-3">

    <a
    href="profile.php"
    class="dashboard-user text-decoration-none"
>
    <i class="bi bi-person-circle me-1"></i>
    <?php echo htmlspecialchars($_SESSION["username"]); ?>
</a>


    <!-- Day / Night Mode -->

    <button
        type="button"
        id="themeToggle"
        class="btn btn-link theme-toggle"
        aria-label="Switch to night mode"
        title="Switch to night mode"
    >

        <i
            class="bi bi-moon"
            id="themeIcon"
        ></i>

    </button>


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

    <!-- ==============================
         Main Content
    =============================== -->
    <main class="container py-4">


        <!-- Welcome Banner -->
        <div class="welcome-card p-4 rounded-4 shadow-sm mb-4">

            <div class="row align-items-center">

                <div class="col-md-7 mb-3 mb-md-0">

                    <p class="small dashboard-label mb-1">
                        STUDENT LEARNING PORTAL
                    </p>

                    <h4 class="fw-bold mb-1">
                        Welcome back, <?php echo htmlspecialchars($full_name); ?>! 👋
                    </h4>

                    <p class="text-muted small mb-0">
                        Enrolled Stream: G.C.E. A/L Technology Stream
                    </p>

                </div>


                <!-- Grade Switcher -->
                <div class="col-md-5 text-md-end">

                    <span class="small text-muted d-block mb-2">
                        Select Grade
                    </span>

                    <div
                        class="btn-group"
                        role="group"
                        aria-label="Grade selection"
                    >

                        <input
                            type="radio"
                            class="btn-check"
                            name="gradeSelect"
                            id="grade12"
                            checked
                        >

                        <label
                            class="btn btn-outline-primary fw-bold"
                            for="grade12"
                        >
                            Grade 12
                        </label>


                        <input
                            type="radio"
                            class="btn-check"
                            name="gradeSelect"
                            id="grade13"
                        >

                        <label
                            class="btn btn-outline-primary fw-bold"
                            for="grade13"
                        >
                            Grade 13
                        </label>

                    </div>

                </div>

            </div>

        </div>

        <!-- Overall Learning Progress -->

<div class="card border-0 shadow-sm mb-4 overall-progress-card">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0 fw-bold overall-progress-title">
                Overall Learning Progress
            </h5>

            <span class="fw-semibold overall-progress-count">

                <?php echo $completed_lessons; ?>
                /
                <?php echo $total_lessons; ?>
                Lessons Completed

            </span>

        </div>


        <div class="progress overall-progress-bar">

            <div
                class="progress-bar overall-progress-fill"
                role="progressbar"
                style="width: <?php echo $overall_progress_percentage; ?>%;"
                aria-valuenow="<?php echo $overall_progress_percentage; ?>"
                aria-valuemin="0"
                aria-valuemax="100"
            >

            </div>

        </div>


        <div class="text-end mt-2">

            <small class="text-muted fw-semibold">

                <?php echo $overall_progress_percentage; ?>% Complete

            </small>

        </div>

    </div>

</div>


        <!-- Section Heading -->
        <div class="mb-3">

            <h5 class="fw-bold mb-1">
                My Subjects
            </h5>

            <p class="text-muted small mb-0">
                Access your subjects and continue your learning.
            </p>

        </div>


        <!-- ==============================
             Subject Cards
        =============================== -->
        <div class="row g-4 mb-5">


            <?php foreach ($student_subjects as $subject): ?>

    <div class="col-md-4">

        <div class="card subject-card h-100 rounded-4 overflow-hidden">

            <!-- Subject Header -->
            <div class="subject-header">

                <span class="badge subject-badge mb-2">

                    <?php echo htmlspecialchars($subject["basket"]); ?>

                </span>

                <h5 class="fw-bold mb-0">

                    <?php echo htmlspecialchars($subject["subject_name"]); ?>

                    (<?php echo htmlspecialchars($subject["subject_code"]); ?>)

                </h5>

            </div>


            <!-- Subject Body -->
            <div class="card-body p-4 d-flex flex-column justify-content-between">

                <p class="text-muted small">

                    <?php

                    if ($subject["subject_code"] === "SFT") {

                        echo "Covers Physics, Chemistry, Mathematics, and IT basics essential for all Technology stream students.";

                    } elseif ($subject["subject_code"] === "ET") {

                        echo "Applied Engineering Systems, Civil, Electrical, and Mechanical fundamentals.";

                    } elseif ($subject["subject_code"] === "BST") {

                        echo "Biological systems, agriculture, biotechnology, and technology applications.";

                    } elseif ($subject["subject_code"] === "ICT") {

                        echo "Programming, Database Management, Networking, and Systems Architecture.";

                    } elseif ($subject["subject_code"] === "AGRI") {

                        echo "Agricultural science, crop production, animal husbandry, and modern agricultural technology.";

                    }

                    ?>

                </p>


                <!-- Progress -->
                <div>

                    <div class="d-flex justify-content-between text-muted small mb-1">

                        <span>Completed Units</span>

                        <span>

                            <?php

                            $subject_id =
                                (int)$subject["subject_id"];

                            echo $subject_progress[$subject_id]["completed_units"];

                            echo " / ";

                            echo $subject_progress[$subject_id]["total_units"];

                            ?>

                        </span>

                    </div>


                    <div
                        class="progress mb-3"
                        style="height: 7px;"
                    >

                        <div
    class="progress-bar dashboard-progress"
    style="width:
        <?php

        $subject_id =
            (int)$subject["subject_id"];

        $completed_units =
            $subject_progress[$subject_id]["completed_units"];

        $total_units =
            $subject_progress[$subject_id]["total_units"];

        $subject_percentage = 0;

        if ($total_units > 0) {

            $subject_percentage =
                round(
                    ($completed_units / $total_units) * 100
                );

        }

        echo $subject_percentage;

        ?>%;
"
></div>

                    </div>


                    <!-- Buttons -->
                    <div class="d-flex gap-2">

                        <a  
                            id="unitsLink-<?php echo $subject["subject_id"]; ?>"
                            href="units.php?subject=<?php echo urlencode($subject["subject_code"]); ?>&grade=12"
                            class="btn btn-dashboard flex-fill fw-bold"
                        >

                            <i class="bi bi-book me-1"></i>

                            View Units

                        </a>


                        <a  
                            id="pastPapersLink-<?php echo $subject["subject_id"]; ?>"
                            href="past-papers.php?subject=<?php echo $subject["subject_id"]; ?>"
                            class="btn btn-outline-primary flex-fill fw-bold"
                        >

                            <i class="bi bi-file-earmark-text me-1"></i>

                            Past Papers

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

<?php endforeach; ?>