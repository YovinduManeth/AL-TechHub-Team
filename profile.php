<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION["user_id"];

$sql = "SELECT full_name, username, email, role
        FROM users
        WHERE user_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    session_destroy();
    header("Location: login.html");
    exit();
}

$user = $result->fetch_assoc();

$stmt->close();
$subject_sql = "SELECT s.subject_name
                FROM student_subjects ss
                INNER JOIN subjects s
                    ON ss.subject_id = s.subject_id
                WHERE ss.user_id = ?
                ORDER BY s.subject_id";

$subject_stmt = $conn->prepare($subject_sql);

$subject_stmt->bind_param("i", $user_id);

$subject_stmt->execute();

$subject_result = $subject_stmt->get_result();

$student_subjects = [];

while ($subject = $subject_result->fetch_assoc()) {
    $student_subjects[] = $subject["subject_name"];
}

$subject_stmt->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile | A/L TechHub</title>

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

<body class="bg-light">


<!-- ==============================
     Navigation Bar
================================ -->

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
            data-bs-target="#profileNavbar"
            aria-controls="profileNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- Navbar Content -->
        <div
            class="collapse navbar-collapse"
            id="profileNavbar"
        >

            <!-- Left Navigation -->
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


            <!-- User Account -->
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