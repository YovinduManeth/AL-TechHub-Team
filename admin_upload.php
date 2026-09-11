<?php

session_start();


// ==========================================
// ADMIN ACCESS PROTECTION
// ==========================================

if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: admin-login.html");
    exit();
}


set_time_limit(600);

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

if ($resource_type === "short_notes") {

    $title = trim($_POST["title"] ?? "");

} else {

    $title = trim($_POST["lesson_title"] ?? "");

}

$description = trim($_POST["description"] ?? "");



// ==========================================
// PAST PAPER UPLOAD
// ==========================================

if ($resource_type === "past_paper") {


    // ==========================================
    // GET PAST PAPER DATA
    // ==========================================

    $subject_id = $_POST["subject_id"] ?? "";

    $paper_year = $_POST["paper_year"] ?? "";

    $paper_title = trim($_POST["paper_title"] ?? "");


    // ==========================================
    // CHECK REQUIRED DATA
    // ==========================================

    if (
    empty($subject_id) ||
    empty($paper_year) ||
    empty($paper_title) ||
    !isset($_FILES["paper_file"])
) {

    die(
        "Please select a subject, enter a year, " .
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
            year,
            title,
            file_path
        )
        VALUES (?, ?, ?, ?)";


$stmt = $conn->prepare($sql);


$stmt->bind_param(
    "iiss",
    $subject_id,
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

    echo "<p>Year: " .
         htmlspecialchars($paper_year) .
         "</p>";


    echo "<p>Title: " .
         htmlspecialchars($paper_title) .
         "</p>";


    echo "<p>The past paper was saved successfully.</p>";


    exit();

}


// ==========================================
// CHECK UNIT
// ==========================================
// Video Lessons and Short Notes need a unit.
// Past Papers do not reach this section.

if (empty($unit_id)) {

    die("Please select a syllabus unit.");

}


// ==========================================
// SHORT NOTES UPLOAD
// ==========================================

if ($resource_type === "short_notes") {


    // ==========================================
    // CHECK REQUIRED DATA
    // ==========================================

    if (
        empty($title) ||
        !isset($_FILES["note_file"])
    ) {

        die(
            "Please enter the note title " .
            "and select a PDF file."
        );

    }


    // ==========================================
    // CHECK FILE UPLOAD
    // ==========================================

    if (
        $_FILES["note_file"]["error"] !==
        UPLOAD_ERR_OK
    ) {

        die("Short note upload failed.");

    }


    $note_file = $_FILES["note_file"];


    // ==========================================
    // CHECK FILE TYPE
    // ==========================================

    $file_extension = strtolower(
        pathinfo(
            $note_file["name"],
            PATHINFO_EXTENSION
        )
    );


    if ($file_extension !== "pdf") {

        die(
            "Only PDF files are allowed " .
            "for short notes."
        );

    }


    // ==========================================
    // CREATE UPLOAD DIRECTORY
    // ==========================================

    $notes_directory = "uploads/notes/";


    if (!is_dir($notes_directory)) {

        mkdir(
            $notes_directory,
            0777,
            true
        );

    }
// ==========================================
    // CREATE UNIQUE FILE NAME
    // ==========================================

    $unique_name =
        "note_" .
        time() .
        "_" .
        bin2hex(random_bytes(4)) .
        ".pdf";


    $note_path =
        $notes_directory .
        $unique_name;


    // ==========================================
    // MOVE PDF FILE
    // ==========================================

    if (
        !move_uploaded_file(
            $note_file["tmp_name"],
            $note_path
        )
    ) {

        die(
            "Failed to save the short note."
        );

    }


    // ==========================================
    // INSERT SHORT NOTE INTO DATABASE
    // ==========================================

    $sql = "INSERT INTO short_notes
            (
                unit_id,
                title,
                file_path
            )
            VALUES (?, ?, ?)";


    $stmt = $conn->prepare($sql);


    $stmt->bind_param(
        "iss",
        $unit_id,
        $title,
        $note_path
    );


    // ==========================================
    // DATABASE INSERT
    // ==========================================

    if (!$stmt->execute()) {


        // Remove uploaded PDF
        // if database insertion fails

        if (file_exists($note_path)) {

            unlink($note_path);

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

    echo "<h2>Short note uploaded successfully!</h2>";


    echo "<p>File: " .
         htmlspecialchars($note_path) .
         "</p>";


    echo "<p>Title: " .
         htmlspecialchars($title) .
         "</p>";


    echo "<p>The short note was saved successfully.</p>";


    exit();

}


// ==========================================
// VIDEO LESSON UPLOAD
// ==========================================

if ($resource_type !== "lesson") {

    die(
        "Currently only Video Lessons, " .
        "Short Notes, and Past Papers are supported."
    );

}


// ==========================================
// CHECK REQUIRED DATA
// ==========================================

if (
    empty($lesson_number) ||
    empty($title) ||
    !isset($_FILES["video"])
) {

    die(
        "Please complete all required lesson fields."
    );

}

// ==========================================
// CHECK VIDEO FILE
// ==========================================

if (
    $_FILES["video"]["error"] !==
    UPLOAD_ERR_OK
) {

    die("Video upload failed.");

}


$video_file = $_FILES["video"];


// ==========================================
// CHECK VIDEO FILE TYPE
// ==========================================

$file_extension = strtolower(
    pathinfo(
        $video_file["name"],
        PATHINFO_EXTENSION
    )
);


if ($file_extension !== "mp4") {

    die(
        "Only MP4 video files are allowed."
    );

}


// ==========================================
// CREATE UNIQUE VIDEO FILE NAME
// ==========================================

$unique_name =
    "lesson_" .
    time() .
    "_" .
    bin2hex(random_bytes(4)) .
    ".mp4";


// ==========================================
// UPLOAD DIRECTORIES
// ==========================================

$video_directory =
    "uploads/videos/";

$video_quality_directory =
    "uploads/videos/quality/";

$audio_directory =
    "uploads/audios/";

// ==========================================
// CREATE DIRECTORIES
// ==========================================

if (!is_dir($video_directory)) {

    mkdir(
        $video_directory,
        0777,
        true
    );

}

if (!is_dir($video_quality_directory)) {

    mkdir(
        $video_quality_directory,
        0777,
        true
    );

}

if (!is_dir($audio_directory)) {

    mkdir(
        $audio_directory,
        0777,
        true
    );

}




// ==========================================
// FILE PATHS
// ==========================================

$video_path =
    $video_directory .
    $unique_name;


$audio_name =
    pathinfo(
        $unique_name,
        PATHINFO_FILENAME
    ) .
    ".mp3";


$audio_path =
    $audio_directory .
    $audio_name;


// ==========================================
// VIDEO QUALITY FILE PATHS
// ==========================================

$video_filename =
    pathinfo(
        $unique_name,
        PATHINFO_FILENAME
    );


$video_1080p_path =
    $video_quality_directory .
    $video_filename .
    "_1080p.mp4";


$video_720p_path =
    $video_quality_directory .
    $video_filename .
    "_720p.mp4";


$video_480p_path =
    $video_quality_directory .
    $video_filename .
    "_480p.mp4";


$video_360p_path =
    $video_quality_directory .
    $video_filename .
    "_360p.mp4";


// ==========================================
// MOVE UPLOADED VIDEO
// ==========================================

if (
    !move_uploaded_file(
        $video_file["tmp_name"],
        $video_path
    )
) {

    die(
        "Failed to save uploaded video."
    );

}

// ==========================================
// GENERATE VIDEO QUALITY VERSIONS
// ==========================================

// 1080p
$result_1080p =
    generateVideoQuality(
        $video_path,
        $video_1080p_path,
        1080
    );

if (!$result_1080p["success"]) {

    die(
        "1080p video generation failed.<br><pre>" .
        htmlspecialchars(
            implode(
                "\n",
                $result_1080p["output"] ?? []
            )
        ) .
        "</pre>"
    );

}


// 720p
$result_720p =
    generateVideoQuality(
        $video_path,
        $video_720p_path,
        720
    );

if (!$result_720p["success"]) {

    die(
        "720p video generation failed.<br><pre>" .
        htmlspecialchars(
            implode(
                "\n",
                $result_720p["output"] ?? []
            )
        ) .
        "</pre>"
    );

}


// 480p
$result_480p =
    generateVideoQuality(
        $video_path,
        $video_480p_path,
        480
    );

if (!$result_480p["success"]) {

    die(
        "480p video generation failed.<br><pre>" .
        htmlspecialchars(
            implode(
                "\n",
                $result_480p["output"] ?? []
            )
        ) .
        "</pre>"
    );

}


// 360p
$result_360p =
    generateVideoQuality(
        $video_path,
        $video_360p_path,
        360
    );

if (!$result_360p["success"]) {

    die(
        "360p video generation failed.<br><pre>" .
        htmlspecialchars(
            implode(
                "\n",
                $result_360p["output"] ?? []
            )
        ) .
        "</pre>"
    );

}


// ==========================================
// GENERATE AUDIO USING FFMPEG
// ==========================================

$audio_result =
    generateAudioFromVideo(
        $video_path,
        $audio_path
    );


// ==========================================
// CHECK AUDIO GENERATION
// ==========================================

if (!$audio_result["success"]) {


    // Remove uploaded video
    // if audio generation fails

    if (file_exists($video_path)) {

        unlink($video_path);

    }


    echo "<h2>Audio generation failed.</h2>";


    echo "<pre>";

    print_r($audio_result);

    echo "</pre>";


    exit();

}


// ==========================================
// VIDEO DURATION
// ==========================================

$duration_seconds = getVideoDuration($video_path);

if ($duration_seconds === false) {

    // Remove generated files if duration cannot be detected

    if (file_exists($video_path)) {
        unlink($video_path);
    }

    if (file_exists($audio_path)) {
        unlink($audio_path);
    }

    if (file_exists($video_1080p_path)) {
        unlink($video_1080p_path);
    }

    if (file_exists($video_720p_path)) {
        unlink($video_720p_path);
    }

    if (file_exists($video_480p_path)) {
        unlink($video_480p_path);
    }

    if (file_exists($video_360p_path)) {
        unlink($video_360p_path);
    }

    die("Could not determine video duration.");
}


// Convert seconds to minutes

$duration_minutes =
    round($duration_seconds / 60, 2);


// ==========================================
// INSERT LESSON INTO DATABASE
// ==========================================

$sql = "INSERT INTO lessons
        (
            unit_id,
            lesson_number,
            title,
            description,
            video_path,
            video_1080p_path,
            video_720p_path,
            video_480p_path,
            video_360p_path,
            audio_path,
            duration_minutes
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


$stmt = $conn->prepare($sql);


$stmt->bind_param(
    "isssssssssd",
    $unit_id,
    $lesson_number,
    $title,
    $description,
    $video_path,
    $video_1080p_path,
    $video_720p_path,
    $video_480p_path,
    $video_360p_path,
    $audio_path,
    $duration_minutes
);


if (!$stmt->execute()) {

    // Remove original video
    if (file_exists($video_path)) {
        unlink($video_path);
    }

    // Remove audio
    if (file_exists($audio_path)) {
        unlink($audio_path);
    }

    // Remove 1080p video
    if (file_exists($video_1080p_path)) {
        unlink($video_1080p_path);
    }

    // Remove 720p video
    if (file_exists($video_720p_path)) {
        unlink($video_720p_path);
    }

    // Remove 480p video
    if (file_exists($video_480p_path)) {
        unlink($video_480p_path);
    }

    // Remove 360p video
    if (file_exists($video_360p_path)) {
        unlink($video_360p_path);
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

echo "<h2>Lesson uploaded successfully!</h2>";


echo "<p>Video: " .
     htmlspecialchars($video_path) .
     "</p>";


echo "<p>Audio: " .
     htmlspecialchars($audio_path) .
     "</p>";


echo "<p>Lesson Number: " .
     htmlspecialchars($lesson_number) .
     "</p>";


echo "<p>FFmpeg successfully generated the audio.</p>";

?>   