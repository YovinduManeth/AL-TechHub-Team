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
// GET LOGGED-IN STUDENT
// ==========================================

$full_name = $_SESSION["full_name"];


// ==========================================
// GET UNIT ID
// ==========================================

$unit_id = $_GET["unit"] ?? "";


// Make sure unit ID is a number

if (!is_numeric($unit_id)) {

    header("Location: dashboard.php");
    exit();

}

$unit_id = (int)$unit_id;


// ==========================================
// GET UNIT DETAILS
// ==========================================

$sql = "SELECT
            units.unit_id,
            units.subject_id,
            units.grade,
            units.unit_number,
            units.unit_title,
            subjects.subject_code,
            subjects.subject_name
        FROM units
        INNER JOIN subjects
            ON units.subject_id = subjects.subject_id
        WHERE units.unit_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $unit_id);

$stmt->execute();

$result = $stmt->get_result();

$unit = $result->fetch_assoc();

$stmt->close();


// ==========================================
// CHECK UNIT EXISTS
// ==========================================

if (!$unit) {

    header("Location: dashboard.php");
    exit();

}


// ==========================================
// GET LESSONS FOR THIS UNIT
// ==========================================

$user_id = (int)$_SESSION["user_id"];

$sql = "SELECT
            lessons.lesson_id,
            lessons.lesson_number,
            lessons.title,
            lessons.description,
            lessons.duration_minutes,
            lessons.video_path,
            lessons.audio_path,

            COALESCE(
                student_progress.completed,
                0
            ) AS completed

        FROM lessons

        LEFT JOIN student_progress
            ON lessons.lesson_id = student_progress.lesson_id
            AND student_progress.user_id = ?

        WHERE lessons.unit_id = ?

        ORDER BY lessons.lesson_id ASC";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ii",
    $user_id,
    $unit_id
);

$stmt->execute();

$result = $stmt->get_result();

$lessons = [];

while ($row = $result->fetch_assoc()) {

    $lessons[] = $row;

}

$stmt->close();

// ==========================================
// Calculate Unit Progress
// ==========================================

$total_lessons = count($lessons);

$completed_lessons = 0;

foreach ($lessons as $lesson) {

    if ($lesson["completed"] == 1) {
        $completed_lessons++;
    }

}

$progress_percentage = 0;

if ($total_lessons > 0) {

    $progress_percentage =
        round(
            ($completed_lessons / $total_lessons) * 100
        );

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
        <?php echo htmlspecialchars($unit["unit_title"]); ?> | A/L TechHub
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


<body>


<!-- ==============================
     Navigation Bar
=============================== -->

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top dashboard-navbar">

    <div class="container">


        <!-- Brand -->

        <a
            class="navbar-brand fw-bold dashboard-brand"
            href="dashboard.php"
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
                        href="index.php"
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


            <!-- Student -->

            <div class="d-flex align-items-center gap-3">

                <span class="dashboard-user">

                    <i class="bi bi-person-circle me-1"></i>

                    <?php echo htmlspecialchars($full_name); ?>

                </span>


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


    <!-- Back -->

    <div class="mb-3">

        <a
            href="units.php?subject=<?php echo urlencode($unit["subject_code"]); ?>"
            class="text-decoration-none"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Back to Units

        </a>

    </div>


    <!-- Unit Header -->

    <div class="welcome-card p-4 rounded-4 shadow-sm mb-4">

        <p class="small dashboard-label mb-1">

            GRADE <?php echo htmlspecialchars($unit["grade"]); ?>

            •
            
            <?php echo htmlspecialchars($unit["subject_code"]); ?>

        </p>


        <h3 class="fw-bold mb-2">

            Unit
            <?php echo str_pad(
                $unit["unit_number"],
                2,
                "0",
                STR_PAD_LEFT
            ); ?>

            —
            <?php echo htmlspecialchars($unit["unit_title"]); ?>

        </h3>


        <p class="text-muted small mb-0">

            Access lessons, learning resources, and assessments for this unit.

        </p>

    </div>

    <!-- Unit Progress -->

<div class="card border-0 shadow-sm mb-4 unit-progress-card">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0 fw-bold unit-progress-title">
                Unit Progress
            </h5>

            <span class="fw-semibold unit-progress-count">

                <?php echo $completed_lessons; ?>
                /
                <?php echo $total_lessons; ?>
                Lessons Completed

            </span>

        </div>


        <div class="progress unit-progress-bar">

            <div
                class="progress-bar unit-progress-fill"
                role="progressbar"
                style="width: <?php echo $progress_percentage; ?>%;"
                aria-valuenow="<?php echo $progress_percentage; ?>"
                aria-valuemin="0"
                aria-valuemax="100"
            >

            </div>

        </div>


        <div class="text-end mt-2">

            <small class="text-muted fw-semibold">

                <?php echo $progress_percentage; ?>% Complete

            </small>

        </div>

    </div>

</div>

    <!-- Learning Content -->

    <div class="mb-3">

        <p class="small dashboard-label mb-1">
            LEARNING CONTENT
        </p>

        <h5 class="fw-bold mb-1">
            Unit Resources
        </h5>

        <p class="text-muted small">
            Select a learning resource to continue.
        </p>

    </div>


    <!-- Resources -->

    <div class="row g-4">

        <!-- Short Notes -->

        <div class="col-md-4">

            <div class="card subject-card h-100 rounded-4">

                <div class="card-body p-4">

                    <div class="mb-3">

                        <i class="bi bi-file-earmark-text-fill fs-2 text-primary"></i>

                    </div>


                    <h5 class="fw-bold">

                        Short Notes

                    </h5>


                    <p class="text-muted small">

                        Read concise notes and summaries for this unit.

                    </p>


                    <a
                        href="short-notes.php?unit=<?php echo $unit_id; ?>"
                        class="btn btn-dashboard fw-bold"
                    >
                        <i class="bi bi-file-earmark-text me-1"></i>
                        View Notes
                    </a>

                </div>

            </div>

        </div>


        <!-- Quiz -->

        <div class="col-md-4">

            <div class="card subject-card h-100 rounded-4">

                <div class="card-body p-4">

                    <div class="mb-3">

                        <i class="bi bi-check-circle-fill fs-2 text-primary"></i>

                    </div>


                    <h5 class="fw-bold">

                        Assessment Quiz

                    </h5>


                    <p class="text-muted small">

                        Test your knowledge with a unit assessment.

                    </p>


                    <a
                        href="#"
                        class="btn btn-dashboard fw-bold"
                    >

                        <i class="bi bi-pencil-square me-1"></i>

                        Take Quiz

                    </a>

                </div>

            </div>

        </div>


    </div>

        </div>