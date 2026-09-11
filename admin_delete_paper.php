<?php

require_once "php/db.php";


// ==========================================
// GET PAPER ID
// ==========================================

$paper_id = $_GET["paper_id"] ?? "";

if (!is_numeric($paper_id)) {

    die("Invalid paper ID.");

}

$paper_id = (int)$paper_id;


// ==========================================
// GET PAPER INFORMATION
// ==========================================

$sql = "SELECT
            paper_id,
            file_path
        FROM past_papers
        WHERE paper_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $paper_id
);

$stmt->execute();

$result = $stmt->get_result();

$paper = $result->fetch_assoc();

$stmt->close();


// ==========================================
// CHECK PAPER EXISTS
// ==========================================

if (!$paper) {

    die("Past paper not found.");

}


// ==========================================
// DELETE PHYSICAL PDF FILE
// ==========================================

$file_path = $paper["file_path"];

if (file_exists($file_path)) {

    unlink($file_path);

}


// ==========================================
// DELETE DATABASE RECORD
// ==========================================

$sql = "DELETE FROM past_papers
        WHERE paper_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $paper_id
);

if ($stmt->execute()) {

    $stmt->close();
    $conn->close();

    header("Location: admin-upload.php?deleted=1");
    exit();

}

$stmt->close();
$conn->close();

die("Failed to delete past paper.");

?>