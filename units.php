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


$sql = "SELECT
            unit_id,
            grade,
            unit_number,
            unit_title
        FROM units
        WHERE subject_id = ?
        AND grade = ?
        ORDER BY unit_number";

$stmt = $conn->prepare($sql);

$stmt->bind_param("is", $subject_id, $grade);

$stmt->execute();

$result = $stmt->get_result();

$units = [];

while ($row = $result->fetch_assoc()) {

    $units[] = $row;

}

$stmt->close();

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