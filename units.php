<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";

 

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}

 

$full_name = $_SESSION["full_name"];


 

$subject_code = $_GET["subject"] ?? "";
$grade = $_GET["grade"] ?? "12";
 

$sql = "SELECT subject_id, subject_name
        FROM subjects
        WHERE subject_code = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $subject_code);

$stmt->execute();

$result = $stmt->get_result();

$subject = $result->fetch_assoc();

$stmt->close();


if (!$subject) {

    die("Subject not found.");

}


$subject_id = $subject["subject_id"];
$subject_name = $subject["subject_name"];


// ==========================================
// GET UNITS + LESSON PROGRESS
// ==========================================

$sql = "SELECT
            units.unit_id,
            units.grade,
            units.unit_number,
            units.unit_title,

            COUNT(lessons.lesson_id) AS total_lessons,

            COUNT(
                CASE
                    WHEN student_progress.completed = 1
                    THEN lessons.lesson_id
                END
            ) AS completed_lessons

        FROM units

        LEFT JOIN lessons
            ON units.unit_id = lessons.unit_id

        LEFT JOIN student_progress
            ON lessons.lesson_id = student_progress.lesson_id
            AND student_progress.user_id = ?

        WHERE units.subject_id = ?
        AND units.grade = ?

        GROUP BY
            units.unit_id,
            units.grade,
            units.unit_number,
            units.unit_title

        ORDER BY units.unit_number";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "iis",
    $_SESSION["user_id"],
    $subject_id,
    $grade
);

$stmt->execute();

$result = $stmt->get_result();

$units = [];

while ($row = $result->fetch_assoc()) {

    $total_lessons = (int) $row["total_lessons"];

    $completed_lessons = (int) $row["completed_lessons"];

    if ($total_lessons > 0) {

        $progress_percentage = round(
            ($completed_lessons / $total_lessons) * 100
        );

    } else {

        $progress_percentage = 0;

    }

    $row["progress_percentage"] = $progress_percentage;

    $units[] = $row;

}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Units | A/L TechHub</title>


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


        <!-- Navigation -->

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


            <!-- Right Side -->

<div class="d-flex align-items-center gap-3">

    <span class="dashboard-user">

        <i class="bi bi-person-circle me-1"></i>

        <?php echo htmlspecialchars($full_name); ?>

    </span>


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


    <!-- Back -->

    <div class="mb-3">

        <a
            href="dashboard.php"
            class="text-decoration-none"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Back to Dashboard

        </a>

    </div>


    <!-- Page Header -->

    <div class="welcome-card p-4 rounded-4 shadow-sm mb-4">

        <p class="small dashboard-label mb-1">

            STUDENT LEARNING PORTAL

        </p>


        <h3 class="fw-bold mb-1">

            <?php echo htmlspecialchars($subject_name); ?>

            Units

        </h3>


        <p class="text-muted small mb-0">

            Select a unit to continue your learning.

        </p>

    </div>


   <!-- ==============================
     Database Units
=============================== -->

<div class="row g-4">

    <?php if (empty($units)): ?>

        <div class="col-12">

            <div class="alert alert-info rounded-4">

                No units are available for this subject yet.

            </div>

        </div>

    <?php else: ?>

        <?php foreach ($units as $unit): ?>

            <div class="col-md-6">

                <div class="card subject-card h-100 rounded-4">

                    <div class="card-body p-4">

                        <span class="badge subject-badge mb-3">

                            Unit
                            <?php
                            echo str_pad(
                                $unit["unit_number"],
                                2,
                                "0",
                                STR_PAD_LEFT
                            );
                            ?>

                        </span>


                        <h5 class="fw-bold">

                            <?php
                            echo htmlspecialchars(
                                $unit["unit_title"]
                            );
                            ?>

                        </h5>


                        <p class="text-muted small">

                            Grade
                            <?php echo htmlspecialchars($unit["grade"]); ?>

                            learning content for this unit.

                        </p>

                        <!-- Unit Progress -->

<div class="mb-3">

    <div class="d-flex justify-content-between align-items-center mb-1">

        <small class="text-muted">

            <?php echo $unit["completed_lessons"]; ?>
            /
            <?php echo $unit["total_lessons"]; ?>

            lessons completed

        </small>


        <small class="fw-bold">

            <?php echo $unit["progress_percentage"]; ?>%

        </small>

    </div>


    <div
        class="progress"
        role="progressbar"
        aria-valuenow="<?php echo $unit["progress_percentage"]; ?>"
        aria-valuemin="0"
        aria-valuemax="100"
        style="height: 8px;"
    >

        <div
            class="progress-bar"
            style="width: <?php echo $unit["progress_percentage"]; ?>%;"
        ></div>

    </div>

</div>


                        <a
                            href="unit.php?unit=<?php echo $unit["unit_id"]; ?>"
                            class="btn btn-dashboard fw-bold"
                        >

                            <i class="bi bi-book me-1"></i>

                            Open Unit

                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

        </div>


    </div>

</main>



<!-- Bootstrap JavaScript -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>