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