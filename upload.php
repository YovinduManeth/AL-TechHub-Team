<?php


require_once "php/db.php";
require_once "php/ffmpeg.php";


// ==========================================
// ONLY ALLOW POST REQUEST
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: admin-upload.php");
    exit();

}


// ==========================================
// GET FORM DATA
// ==========================================

$resource_type = $_POST["resource_type"] ?? "";

$unit_id = $_POST["unit_id"] ?? "";

$lesson_number = trim($_POST["lesson_number"] ?? "");

$title = trim($_POST["title"] ?? "");

$description = trim($_POST["description"] ?? "");


// ==========================================
// PAST PAPER UPLOAD
// ==========================================

if ($resource_type === "past_paper") {


    // ==========================================
    // GET PAST PAPER DATA
    // ==========================================

    $subject_id = $_POST["subject_id"] ?? "";

    $paper_grade = $_POST["paper_grade"] ?? "";

    $paper_year = $_POST["paper_year"] ?? "";

    $paper_title = trim($_POST["paper_title"] ?? "");


    // ==========================================
    // CHECK REQUIRED DATA
    // ==========================================

    if (
        empty($subject_id) ||
        empty($paper_grade) ||
        empty($paper_year) ||
        empty($paper_title) ||
        !isset($_FILES["paper_file"])
    ) {

        die(
            "Please select a subject, grade, year, " .
            "enter a paper title, and select a PDF file."
        );

    }


    // ==========================================
    // CHECK SUBJECT ID
    // ==========================================

    if (!is_numeric($subject_id)) {

        die("Invalid subject selected.");

    }

    $subject_id = (int)$subject_id;


    // ==========================================
    // CHECK GRADE
    // ==========================================

    if (
        $paper_grade !== "12" &&
        $paper_grade !== "13"
    ) {

        die("Invalid grade selected.");

    }


    // ==========================================
    // CHECK YEAR
    // ==========================================

    if (
        !is_numeric($paper_year) ||
        (int)$paper_year < 2000 ||
        (int)$paper_year > 2100
    ) {

        die("Invalid year.");

    }

    $paper_year = (int)$paper_year;


    // ==========================================
    // CHECK FILE UPLOAD
    // ==========================================

    if (
        $_FILES["paper_file"]["error"] !==
        UPLOAD_ERR_OK
    ) {

        die("Past paper upload failed.");

    }


    $paper_file = $_FILES["paper_file"];


    // ==========================================
    // CHECK FILE TYPE
    // ==========================================

    $file_extension = strtolower(
        pathinfo(
            $paper_file["name"],
            PATHINFO_EXTENSION
        )
    );


    if ($file_extension !== "pdf") {

        die(
            "Only PDF files are allowed " .
            "for past papers."
        );

    }


    // ==========================================
    // CREATE UPLOAD DIRECTORY
    // ==========================================

    $past_paper_directory =
        "uploads/past_papers/";


    if (!is_dir($past_paper_directory)) {

        mkdir(
            $past_paper_directory,
            0777,
            true
        );

    }


    // ==========================================
    // CREATE UNIQUE FILE NAME
    // ==========================================

    $unique_name =
        "paper_" .
        time() .
        "_" .
        bin2hex(random_bytes(4)) .
        ".pdf";


    $paper_path =
        $past_paper_directory .
        $unique_name;


    // ==========================================
    // MOVE PDF FILE
    // ==========================================

    if (
        !move_uploaded_file(
            $paper_file["tmp_name"],
            $paper_path
        )
    ) {

        die(
            "Failed to save the past paper."
        );

    }


    // ==========================================
    // INSERT PAST PAPER INTO DATABASE
    // ==========================================

    $sql = "INSERT INTO past_papers
            (
                subject_id,
                grade,
                year,
                title,
                file_path
            )
            VALUES (?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($sql);


    $stmt->bind_param(
        "isiss",
        $subject_id,
        $paper_grade,
        $paper_year,
        $paper_title,
        $paper_path
    );


    // ==========================================
    // DATABASE INSERT
    // ==========================================

    if (!$stmt->execute()) {


        // Remove uploaded PDF
        // if database insertion fails

        if (file_exists($paper_path)) {

            unlink($paper_path);

        }


        die(
            "Database error: " .
            $stmt->error
        );

    }


    $stmt->close();


    // ==========================================
    // SUCCESS
    // ==========================================

    echo "<h2>Past paper uploaded successfully!</h2>";


    echo "<p>File: " .
         htmlspecialchars($paper_path) .
         "</p>";


    echo "<p>Subject ID: " .
         htmlspecialchars($subject_id) .
         "</p>";


    echo "<p>Grade: " .
         htmlspecialchars($paper_grade) .
         "</p>";


    echo "<p>Year: " .
         htmlspecialchars($paper_year) .
         "</p>";


    echo "<p>Title: " .
         htmlspecialchars($paper_title) .
         "</p>";


    echo "<p>The past paper was saved successfully.</p>";


    exit();

}

