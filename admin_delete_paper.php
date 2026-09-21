<?php

session_start();


if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: admin-login.html");
    exit();
}


require_once "php/db.php";

$paper_id = $_GET["paper_id"] ?? "";

if (!is_numeric($paper_id)) {

    die("Invalid paper ID.");

}

$paper_id = (int)$paper_id;


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

if (!$paper) {

    die("Past paper not found.");

}


$file_path = $paper["file_path"];

if (file_exists($file_path)) {

    unlink($file_path);

}


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