<?php

require_once "php/db.php";

$message = "";
$message_type = "";


// ==========================================
// GET ALL UNITS
// ==========================================

$sql = "SELECT
            units.unit_id,
            units.grade,
            units.unit_number,
            units.unit_title,
            subjects.subject_code,
            subjects.subject_name
        FROM units
        INNER JOIN subjects
            ON units.subject_id = subjects.subject_id
        ORDER BY units.grade ASC,
                 subjects.subject_code ASC,
                 units.unit_number ASC";

$result = $conn->query($sql);

$units = [];

while ($row = $result->fetch_assoc()) {

    $units[] = $row;

}


// ==========================================
// GET ALL PAST PAPERS
// ==========================================

$sql = "SELECT
            past_papers.paper_id,
            past_papers.year,
            past_papers.title,
            past_papers.file_path,
            past_papers.created_at,
            subjects.subject_code,
            subjects.subject_name

        FROM past_papers

        INNER JOIN subjects
            ON past_papers.subject_id = subjects.subject_id

        ORDER BY past_papers.year DESC,
                 subjects.subject_code ASC";

$result = $conn->query($sql);

$past_papers = [];

while ($row = $result->fetch_assoc()) {

    $past_papers[] = $row;

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Portal | A/L TechHub</title>

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


<body class="admin-page">


    <!-- =========================================
         ADMIN NAVBAR
    ========================================== -->

    <nav class="navbar navbar-expand-lg admin-navbar sticky-top">

        <div class="container">

            <a
                class="navbar-brand fw-bold admin-brand"
                href="admin-upload.php"
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
                            class="nav-link admin-nav-link active"
                            href="admin-upload.php"
                        >

                            <i class="bi bi-cloud-upload me-1"></i>

                            Upload Content

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


    