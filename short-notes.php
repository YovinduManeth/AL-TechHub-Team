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
// GET SHORT NOTES FOR THIS UNIT
// ==========================================

$sql = "SELECT
            note_id,
            title,
            file_path,
            created_at

        FROM short_notes

        WHERE unit_id = ?

        ORDER BY note_id ASC";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $unit_id);

$stmt->execute();

$result = $stmt->get_result();

$notes = [];

while ($row = $result->fetch_assoc()) {

    $notes[] = $row;

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

    <title>
        Short Notes |
        <?php echo htmlspecialchars($unit["unit_title"]); ?> |
        A/L TechHub
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

<!-- =========================================
     NAVIGATION BAR
========================================== -->

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
            aria-controls="navPortal"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- Navigation -->

        <div
            class="collapse navbar-collapse"
            id="navPortal"
        >

            <ul class="navbar-nav me-auto ms-lg-4">


                <!-- Home -->

                <li class="nav-item">

                    <a
                        class="nav-link dashboard-nav-link"
                        href="index.php"
                    >

                        <i class="bi bi-house me-1"></i>

                        Home

                    </a>

                </li>


                <!-- Dashboard -->

                <li class="nav-item">

                    <a
                        class="nav-link dashboard-nav-link active"
                        href="dashboard.php"
                    >

                        <i class="bi bi-grid-1x2-fill me-1"></i>

                        Dashboard

                    </a>

                </li>


                <!-- Contact -->

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



<!-- =========================================
     MAIN CONTENT
========================================== -->

<main class="container py-4">


    <!-- =========================================
         BACK TO UNIT
    ========================================== -->

    <div class="mb-3">

        <a
            href="unit.php?unit=<?php echo $unit_id; ?>"
            class="text-decoration-none"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Back to Unit

        </a>

    </div>



    <!-- =========================================
         PAGE HEADER
    ========================================== -->

    <div class="welcome-card p-4 rounded-4 shadow-sm mb-4">


        <p class="small dashboard-label mb-1">

            GRADE
            <?php echo htmlspecialchars($unit["grade"]); ?>

            •
            
            <?php echo htmlspecialchars($unit["subject_code"]); ?>

        </p>


        <h3 class="fw-bold mb-2">

            Unit
            <?php
            echo str_pad(
                $unit["unit_number"],
                2,
                "0",
                STR_PAD_LEFT
            );
            ?>

            —
            <?php echo htmlspecialchars($unit["unit_title"]); ?>

        </h3>


        <p class="text-muted small mb-0">

            Short notes and concise learning materials
            for this unit.

        </p>

    </div>



    <!-- =========================================
         SHORT NOTES HEADING
    ========================================== -->

    <div class="mb-4">

        <p class="small dashboard-label mb-1">

            LEARNING MATERIALS

        </p>


        <h5 class="fw-bold mb-1">

            Short Notes

        </h5>


        <p class="text-muted small mb-0">

            Read or download the available PDF notes
            for this unit.

        </p>

    </div>