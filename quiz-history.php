<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";


// ==========================================
// REQUIRE LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}


// ==========================================
// GET LOGGED-IN USER
// ==========================================

$user_id = (int)$_SESSION["user_id"];

$full_name = $_SESSION["full_name"];
$username = $_SESSION["username"];


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

            quizzes.title AS quiz_title,

            units.unit_number,
            units.unit_title,

            subjects.subject_code,
            subjects.subject_name

        FROM quiz_attempts

        INNER JOIN quizzes
            ON quiz_attempts.quiz_id = quizzes.quiz_id

        INNER JOIN units
            ON quizzes.unit_id = units.unit_id

        INNER JOIN subjects
            ON units.subject_id = subjects.subject_id

        WHERE quiz_attempts.user_id = ?

        ORDER BY quiz_attempts.attempted_at DESC";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$quiz_history = [];

while ($row = $result->fetch_assoc()) {

    $quiz_history[] = $row;

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

    <title>Quiz History | A/L TechHub</title>


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


                <!-- Left Navigation Links -->

                <ul
                    class="navbar-nav me-auto ms-lg-4"
                >

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
                            class="nav-link dashboard-nav-link"
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

                <div
                    class="d-flex align-items-center gap-3"
                >


                    <!-- Profile -->

                    <a
                        href="profile.php"
                        class="dashboard-user text-decoration-none"
                    >

                        <i class="bi bi-person-circle me-1"></i>

                        <?php
                        echo htmlspecialchars($username);
                        ?>

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


                    <!-- Logout -->

                    <a
                        href="php/logout.php"
                        class="btn btn-outline-primary btn-sm px-3"
                    >

                        <i
                            class="bi bi-box-arrow-right me-1"
                        ></i>

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


        <!-- Page Header -->

        <div class="mb-4">

            <p class="small dashboard-label mb-1">

                STUDENT LEARNING PORTAL

            </p>


            <h4 class="fw-bold mb-1">

                Quiz History

            </h4>


            <p class="text-muted small mb-0">

                Review your previous quiz attempts, scores, and results.

            </p>

        </div>


        <!-- ==============================
             Quiz History Card
        =============================== -->

        <div
            class="card rounded-4 shadow-sm border-0 mb-4"
        >

            <div class="card-body p-4">


                <?php if (count($quiz_history) > 0): ?>


                    <div class="table-responsive">

                        <table
                            class="table align-middle mb-0"
                        >

                            <thead>

                                <tr>

                                    <th>Quiz</th>

                                    <th>Subject</th>

                                    <th>Unit</th>

                                    <th>Score</th>

                                    <th>Correct</th>

                                    <th>Percentage</th>

                                    <th>Status</th>

                                    <th>Date</th>

                                    <th>Action</th>

                                </tr>

                            </thead>


                            <tbody>


                                <?php foreach ($quiz_history as $attempt): ?>


                                    <tr>


                                        <!-- Quiz -->

                                        <td>

                                            <div class="fw-semibold">

                                                <?php
                                                echo htmlspecialchars(
                                                    $attempt["quiz_title"]
                                                );
                                                ?>

                                            </div>

                                        </td>