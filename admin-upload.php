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


    <!-- =========================================
         MAIN CONTENT
    ========================================== -->

    <main class="container py-5">


        <!-- Page Heading -->

        <div class="admin-page-heading mb-4">

            <p class="admin-label mb-1">
                ADMINISTRATION PORTAL
            </p>

            <h1 class="fw-bold mb-2">
                Content Management
            </h1>

            <p class="text-muted mb-0">
                Manage lessons, short notes, past papers, and quiz questions
                for the student learning portal.
            </p>

        </div>



        <!-- =========================================
             UPLOAD CARD
        ========================================== -->

        <div class="row justify-content-center">

            <div class="col-lg-9 col-xl-8">

                <div class="admin-upload-card">


                    <!-- Card Header -->

                    <div class="admin-upload-header">

                        <div class="admin-upload-icon">

                            <i class="bi bi-cloud-arrow-up-fill"></i>

                        </div>


                        <div>

                            <h4 class="fw-bold mb-1">
                                Learning Content Management
                            </h4>

                            <p class="mb-0">
                                Add and manage learning resources for students.
                            </p>

                        </div>

                    </div>



                    <!-- Form -->

                    <div class="admin-upload-body">

                        <form
                            action="admin_upload.php"
                            method="POST"
                            enctype="multipart/form-data"
                        >


                            <!-- =========================================
                                 RESOURCE TYPE
                            ========================================== -->

                            <div class="mb-4">

                                <label class="form-label fw-bold">

                                    <i class="bi bi-collection me-1"></i>

                                    Resource Type

                                </label>

                                <select
                                    class="form-select"
                                    name="resource_type"
                                    id="resourceType"
                                    required
                                >

                                    <option value="" selected disabled>
                                        -- Select Resource Type --
                                    </option>

                                    <option value="lesson">
                                        Video Lesson
                                    </option>

                                    <option value="short_notes">
                                        Unit Short Notes
                                    </option>

                                    <option value="past_paper">
                                        Past Paper
                                    </option>

                                    <option value="quiz">
                                        Quiz Question
                                    </option>

                                </select>

                            </div>



                            <!-- =========================================
                                 LEARNING CONTENT LOCATION
                            ========================================== -->

                            <div class="mb-4" id="unitLocationFields">

                            <label class="form-label fw-bold">

                                <i class="bi bi-book me-1"></i>

                                Learning Content Location

                            </label>


                                <!-- Grade -->

                                <select
                                    class="form-select mb-2"
                                    name="grade"
                                    id="generalGrade"
                                    required
                                >

                                    <option value="" selected disabled>
                                        -- Select Grade --
                                    </option>

                                    <option value="12">
                                        Grade 12
                                    </option>

                                    <option value="13">
                                        Grade 13
                                    </option>

                                </select>


                                <!-- Unit -->

                                <select
                                    class="form-select"
                                    name="unit_id"
                                    id="unitSelect"
                                    required
                                >

                                    <option value="" selected disabled>
                                        -- Select Syllabus Unit --
                                    </option>

                                    <?php foreach ($units as $unit): ?>

                                        <option
                                            value="<?php echo $unit["unit_id"]; ?>"
                                            data-grade="<?php echo htmlspecialchars($unit["grade"]); ?>"
                                        >

                                            <?php echo htmlspecialchars($unit["subject_code"]); ?>

                                            -

                                            Grade
                                            <?php echo htmlspecialchars($unit["grade"]); ?>

                                            -

                                            Unit
                                            <?php echo str_pad(
                                                $unit["unit_number"],
                                                2,
                                                "0",
                                                STR_PAD_LEFT
                                            ); ?>

                                            :

                                            <?php echo htmlspecialchars($unit["unit_title"]); ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>



                            <!-- =========================================
                                 VIDEO LESSON FIELDS
                            ========================================== -->

                            <div id="lessonFields">


                                <!-- Lesson Number -->

                                <div class="mb-4">

                                    <label class="form-label fw-bold">

                                        <i class="bi bi-list-ol me-1"></i>

                                        Lesson Number

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="lesson_number"
                                        id="lessonNumber"
                                        placeholder="e.g. 1.1"
                                    >

                                    <div class="form-text">

                                        Enter the lesson number according to
                                        the unit.

                                        Example: 1.1, 1.2, 1.3

                                    </div>

                                </div>



                                <!-- Lesson Title -->

                                <div class="mb-4">

                                    <label class="form-label fw-bold">

                                        <i class="bi bi-type me-1"></i>

                                        Lesson Title

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="lesson_title"
                                        id="lessonTitle"
                                        placeholder="e.g. SI Units & Measurement"
                                    >

                                </div>



                                <!-- Description -->

                                <div class="mb-4">

                                    <label class="form-label fw-bold">

                                        <i class="bi bi-text-paragraph me-1"></i>

                                        Lesson Description

                                    </label>

                                    <textarea
                                        class="form-control"
                                        name="description"
                                        id="lessonDescription"
                                        rows="4"
                                        placeholder="Brief overview of the lesson..."
                                    ></textarea>

                                </div>



                                <!-- Video Upload -->

                                <div class="admin-file-box mb-4">

                                    <div class="d-flex align-items-center mb-2">

                                        <i
                                            class="bi bi-file-earmark-play-fill admin-file-icon me-2"
                                        ></i>

                                        <label class="form-label fw-bold mb-0">

                                            Lesson Video File

                                        </label>

                                    </div>


                                    <p class="small text-muted mb-3">

                                        Upload the MP4 video for this lesson.

                                    </p>


                                    <input
                                        type="file"
                                        class="form-control"
                                        name="video"
                                        id="videoFile"
                                        accept="video/mp4"
                                    >


                                    <div class="admin-info mt-3">

                                        <i class="bi bi-info-circle-fill"></i>

                                        <span>

                                            The uploaded video will be
                                            processed server-side using FFmpeg
                                            to generate a 64kbps MP3
                                            data-saver audio stream.

                                        </span>

                                    </div>

                                </div>



            <!-- Processing Information -->

                                <div class="admin-process-box mb-4">

                                    <div class="d-flex align-items-center">

                                        <i
                                            class="bi bi-cpu-fill admin-process-icon me-2"
                                        ></i>

                                        <div>

                                            <strong>
                                                Automatic Processing
                                            </strong>

                                            <p class="small text-muted mb-0">

                                                FFmpeg will automatically
                                                generate the data-saver audio
                                                version after submission.

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <!-- =========================================
                                 SHORT NOTES FIELDS
                            ========================================== -->

                            <div
                                id="shortNotesFields"
                                style="display: none;"
                            >


                                <!-- Note Title -->

                                <div class="mb-4">

                                    <label class="form-label fw-bold">

                                        <i class="bi bi-type me-1"></i>

                                        Short Note Title

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="title"
                                        id="noteTitle"
                                        placeholder="e.g. SI Base Units - Short Notes"
                                    >

                                </div>



                                <!-- PDF Upload -->

                                <div class="admin-file-box mb-4">

                                    <div class="d-flex align-items-center mb-2">

                                        <i
                                            class="bi bi-file-earmark-pdf-fill admin-file-icon me-2"
                                        ></i>

                                        <label class="form-label fw-bold mb-0">

                                            Short Notes PDF

                                        </label>

                                    </div>


                                    <p class="small text-muted mb-3">

                                        Upload the short notes as a PDF file.

                                    </p>


                                    <input
                                        type="file"
                                        class="form-control"
                                        name="note_file"
                                        id="noteFile"
                                        accept="application/pdf"
                                    >


                                    <div class="admin-info mt-3">

                                        <i class="bi bi-info-circle-fill"></i>

                                        <span>

                                            Only PDF files are accepted for
                                            unit short notes.

                                        </span>

                                    </div>

                                </div>

                            </div>


                            
                                <!-- =========================================
                                    PAST PAPER FIELDS
                                ========================================== -->

                                                            
                                    <div id="pastPaperFields" style="display: none;">

                                        <!-- Subject -->
                                        <div class="mb-4">

                                            <label class="form-label fw-bold">
                                                <i class="bi bi-book me-1"></i>
                                                Subject
                                            </label>

                                            <select
                                                class="form-select"
                                                name="subject_id"
                                                id="pastPaperSubject"
                                            >

                                                <option value="" selected disabled>
                                                    -- Select Subject --
                                                </option>

                                                <?php
                                                $subject_result = $conn->query(
                                                    "SELECT subject_id, subject_code, subject_name
                                                    FROM subjects
                                                    ORDER BY subject_code"
                                                );

                                                while ($subject = $subject_result->fetch_assoc()):
                                                ?>

                                                    <option value="<?php echo $subject["subject_id"]; ?>">

                                                        <?php echo htmlspecialchars($subject["subject_code"]); ?>
                                                        -
                                                        <?php echo htmlspecialchars($subject["subject_name"]); ?>

                                                    </option>

                                                <?php endwhile; ?>

                                            </select>

                                        </div>


                        

                                        <!-- Year -->

                                        <div class="mb-4">

                                            <label class="form-label fw-bold">

                                                <i class="bi bi-calendar me-1"></i>

                                                Year

                                            </label>

                                            <input
                                                type="number"
                                                class="form-control"
                                                name="paper_year"
                                                placeholder="e.g. 2025"
                                                min="2000"
                                                max="2100"
                                            >

                                        </div>


                                        <!-- Title -->

                                        <div class="mb-4">

                                            <label class="form-label fw-bold">

                                                <i class="bi bi-type me-1"></i>

                                                Paper Title

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="paper_title"
                                                placeholder="e.g. 2025 A/L ICT Past Paper"
                                            >

                                        </div>


                                        <!-- PDF -->

                                        <div class="admin-file-box mb-4">

                                            <div class="d-flex align-items-center mb-2">

                                                <i class="bi bi-file-earmark-pdf-fill admin-file-icon me-2"></i>

                                                <label class="form-label fw-bold mb-0">

                                                    Past Paper PDF

                                                </label>

                                            </div>

                                            <p class="small text-muted mb-3">

                                                Upload the past paper PDF.

                                            </p>

                                            <input
                                                type="file"
                                                class="form-control"
                                                name="paper_file"
                                                accept="application/pdf"
                                            >

                                        </div>

                                    </div>



                            <!-- =========================================
                                 SUBMIT BUTTON
                            ========================================== -->

                            <button
                                type="submit"
                                class="btn btn-admin-primary w-100 py-3 fw-bold"
                                id="submitButton"
                            >

                                <i class="bi bi-cloud-upload me-1"></i>

                                Upload Master & Generate Audio Stream

                            </button>


                        </form>

                    </div>

                </div>

            </div>

        </div>

                <!-- =========================================
             PAST PAPER MANAGEMENT
        ========================================== -->

                <div
            class="row justify-content-center mx-auto"
            id="pastPaperManagement"
            style="display: none;"
        >

            <div class="col-12 col-lg-10 col-xl-9 mx-auto">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div>

                                <h4 class="fw-bold mb-1">
                                    Past Paper Management
                                </h4>

                                <p class="text-muted mb-0">
                                    View and manage uploaded past papers.
                                </p>

                            </div>

                            <span class="badge bg-primary">
                                <?php echo count($past_papers); ?> Papers
                            </span>

                        </div>


                        <?php if (empty($past_papers)): ?>

                            <div class="text-center py-5">

                                <i class="bi bi-file-earmark-pdf fs-1 text-muted"></i>

                                <p class="text-muted mt-3 mb-0">
                                    No past papers have been uploaded yet.
                                </p>

                            </div>

                        <?php else: ?>

                            <div class="table-responsive">

                                <table class="table table-hover align-middle">

                                    <thead>

                                        <tr>

                                            <th>Subject</th>
                                            <th>Year</th>
                                            <th>Title</th>
                                            <th>Uploaded</th>
                                            <th class="text-center">Actions</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($past_papers as $paper): ?>

                                            <tr>

                                                <td>

                                                    <span class="badge bg-primary">

                                                        <?php
                                                        echo htmlspecialchars(
                                                            $paper["subject_code"]
                                                        );
                                                        ?>

                                                    </span>

                                                </td>


                                                <td class="fw-semibold">

                                                    <?php
                                                    echo htmlspecialchars(
                                                        $paper["year"]
                                                    );
                                                    ?>

                                                </td>


                                                <td>

                                                    <?php
                                                    echo htmlspecialchars(
                                                        $paper["title"]
                                                    );
                                                    ?>

                                                </td>


                                                <td class="text-muted">

                                                    <?php
                                                    echo date(
                                                        "d M Y, h:i A",
                                                        strtotime(
                                                            $paper["created_at"]
                                                        )
                                                    );
                                                    ?>

                                                </td>


                                                <td>

                                                    <div class="d-flex gap-2 justify-content-center">

                                                        <a
                                                            href="<?php echo htmlspecialchars($paper["file_path"]); ?>"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="btn btn-sm btn-outline-primary"
                                                        >

                                                            <i class="bi bi-eye me-1"></i>
                                                            Open

                                                        </a>


                                                        <a
                                                            href="admin_delete_paper.php?paper_id=<?php echo $paper["paper_id"]; ?>"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Are you sure you want to delete this past paper?');"
                                                        >

                                                            <i class="bi bi-trash me-1"></i>
                                                            Delete

                                                        </a>

                                                    </div>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </main>